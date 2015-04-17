<?php

class ExternalAuthController extends \BaseController {

	// Private vars for this controller only
	const MWL_SERVER	= 'mwl.controlpad.com';
	const MWL_UN		= 'llr_txn';
	const MWL_PASS		= 'ilovetexas';
 	const MWL_DB 		= 'llr';
	private $mwl_cachetime	= 3600;
	private	$mwl_cache	= '../app/storage/cache/mwl/';
	private	$SESSIONKEY_TIMEOUT = 3600;

	// These items are to be ignored and not shown
	private $ignore_inv	= ['OLIVIA', 'NENA & CO.', 'DDM SLEEVE', 'DDM SLEEVELESS'];

	// Thanks Ampersand, just thank you for screwing things up.
	public function escapemodelname($modelname) {
		$modelname = str_replace('&','and',$modelname);
		return(htmlspecialchars($modelname));
	}

	public static function getUserByKey($key = '') {
		if (empty($key) && Auth::user()) {
			\Log::info("No Key, but Authed = Return warehouse inventory user");
			return(false);
		}

		\Log::info("Get User by Key {$key}");
		if (empty($key) || $key == '{"Code" : 401, "Message" : "failed invalid username or password"}') {
           \Log::info("Veilen Schlecht - Empty Key");
            return App::abort(401, json_encode(array('error'=>'true','message'=>'No Key Specified - Please Login and try again')));
        }

		\Log::info("Pulling all the way back from the MWL: {$key}");			
		try {
			$mysqli = new mysqli(self::MWL_SERVER, self::MWL_UN, self::MWL_PASS, self::MWL_DB);
		}
		catch (Exception $e)
		{
			\Log::error("{$key} this this key is not locked to a user account in mwl!");
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return App::abort(401, json_encode(array('error'=>'true','message'=>'Session Key Expired - Please Login and try again (2)')));
		}
		// This is not good .. WHERE'S MY API!
		$Q = "SELECT username FROM sessionkey LEFT JOIN users ON (userid=id) WHERE `key`='".$mysqli->escape_string($key)."' LIMIT 1";
		$res = $mysqli->query($Q);
		$mwluser = $res->fetch_assoc();
		\Log::info('FOUND: '.print_r($mwluser['username'],true));

		$mbr = User::find($mwluser['username']);
        //$mbr = User::where('key', 'LIKE', $key.'|%')->first();
        if (!isset($mbr) && Session::get('repsale')) {
            \Log::error("{$key} this is a rep sale, and this key is not locked to a user account!");
			return App::abort(401, json_encode(array('error'=>'true','message'=>'Session Key Expired - Please Login and try again (1)')));
		}
		else if ($mbr) { 
			\Log::info("{$key} = {$mbr->id}");
		}

		return $mbr;
	}

	// STUB for removing inventory
	public function rmInventory($key,$id,$quan) {
		// Magic database voodoo
        $mbr	= self::getUserByKey($key);
		
		$prod = Product::where('user_id','=',$mbr->id)->where('id','=',$id)->get()->first();


		if (!empty($prod)) { 
			if ($prod->quantity >= intval($quan)) {
				$prod->quantity = $prod->quantity - intval($quan);
				$prod->save();
				\Log::info("\tRemoved item {$quan} / {$prod->quantity} of {$id} from user #{$mbr->id}");
				return(Response::json(array('error'=>false,'message'=>'success','remaining'=>intval($prod->quantity),'attempted'=>$quan),200));
			}
			else {
				\Log::info("\tFailed to remove item {$quan} / {$prod->quantity} of {$id} from user #{$mbr->id}");
				return(Response::json(array('error'=>true,'message'=>'fail','remaining'=>intval($prod->quantity),'attempted'=>$quan),200));
			}
		}
		else {
			return(Response::json(array('error'=>true,'message'=>'Item not found'),200));
		}

	}

	/* Inventory 2.0 */
	public function getInventory20($key = '', $location='')
	{
		// Magic database voodoo
        $mbr	= self::getUserByKey($key);
		if ($mbr) $location = $mbr->first_name.' '.$mbr->last_name;

		// Get MAIN inventory as default
		if (empty($location) || (isset($mbr) && $mbr->id == 0)) // $key == 0 || $key == null)
		{
			$location = 'Main';

			// Return the user is able to log in, but shut out of MWL
			$key = Self::midauth(Config::get('site.mwl_username'), Config::get('site.mwl_password')); 
		}

		$server_output = '';

		// Generates the list of items from the product table per user
		//if (!empty($mbr) && $mbr->id > 0) {
		if (!empty($mbr)) {
			$p = Product::where('user_id','=',$mbr->id)->get(array('id','name','quantity','make','model','rep_price','size','sku','image'));
			$itemlist	= [];
			$count		= 0;

			foreach($p as $item) 
			{
                // get product images
                $model      		= $this->escapemodelname($item->name);
                $dbImage            = '';
                $attachment_images  = [];

                $attachments = Attachment::where('attachable_type', 'Product')->where('attachable_id', $item->id)->where('featured', 1)->get();
                foreach ($attachments as $attachment) {
                    $dbImage = Media::find($attachment->media_id);
					$dbImage->url = explode('.', $dbImage->url);
					//if (isset($dbImage->url[1])) $dbImage->url = '/uploads/' . $dbImage->url[0] . '-sm.' . $dbImage->url[1];
                }

				// Please keep the full https path in here it is for IOS
                $image      = (!empty($dbImage) && isset($dbImage->url)) ? $dbImage->url : 'https://mylularoe.com/img/media/'.rawurlencode($model).'.jpg';
				$item->image = $image;
				$itemlist[$model][] = $item;
			}

/*
			// Reorder this with numerical indeces
			if (isset($items)) {
				foreach($items as $k=>$v)
				{
					$itemlist[$count++] = $v;
				}
			}
			else $itemlist = null;
*/

			return(Response::json($itemlist, 200, [], JSON_PRETTY_PRINT));
		}


		// Simple caching - probably a better way to do this
		if (!is_dir($this->mwl_cache)) @mkdir($this->mwl_cache);
		$mwlcachefile = $this->mwl_cache.urlencode($location).'.json';
		if (file_exists($mwlcachefile)) {
			$fs = stat($mwlcachefile);
			if (time() - $fs['ctime'] > $this->mwl_cachetime || filesize($mwlcachefile) < 500) {
				@unlink($mwlcachefile);
			}
			else {
				$server_output = file_get_contents($mwlcachefile);
			}
		}

		// Only pull from the inventory server 
		// if we don't have any output
		if (empty($server_output)) {
			// Pull this out into an actual class for MWL php api
			$location = rawurlencode($location);
			$ch = curl_init();

			// Set this to HTTPS TLS / SSL
			$curlstring = Config::get('site.mwl_api').'/llr/'.htmlentities($location,ENT_QUOTES,'UTF-8').'/inventorylist?sessionkey='.$key;
			curl_setopt($ch, CURLOPT_URL, $curlstring);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			if ($errno = curl_errno($ch)) {
				$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
				return(Response::json($result,401));
			}
			curl_close ($ch);
			file_put_contents($mwlcachefile, $server_output);
		}

		// Start transforming the server output data
		$output		= json_decode($server_output, true); // true = array
		$model		= '';
		$lastmodel	= '';
		$count		= 0;
		$itemlist	= [];

		if (empty($output)) { 
			// Last resort!
			$output = json_decode(file_get_contents($mwlcachefile));
			\Log::info('Nothing returned from inventory system!');
			//return Response::json(array('errors'=>true,'message'=>'Nothing returned from inventory system.'),500);
		}

        if(array_key_exists('Code',$output) && $output['Code'] == '400'){
			unlink($mwlcachefile);
            return Response::json(array('errors'=>true,'message'=> $output['Message'],'errno'=>'400'), 500);
        }

		// Transform the output to the appropriate IOS format
		foreach($output['Inventory'] as $item) 
		{

			$itemnumber = $item['Item']['Part']['Number'];
			$quantity	= $item['Item']['Quantity']['OnHand'];

			ltrim(rtrim($itemnumber));

			$model = preg_replace('/ -.*$/','',$item['Item']['Part']['Number']);

			// May want to ignore some inventory items here
			if (in_array(strtoupper($model), $this->ignore_inv)) {
				continue;
			}

			$itemList[$model] = '';
			
			// Delimiting sizes with hyphen and spaces
			if (strpos($itemnumber,' -') === false) 
			{
				$size  = 'NA';	
			}
			else list($model, $size) = explode(' -',$itemnumber);

			$model		= $this->escapemodelname($model);
			
			// Initialize this set of item data
			if (!isset($items[$model]))
			{
				$items[$model] = array(
				'model'			=>$model,
				'UPC'			=>$item['Item']['UPC'],
				'SKU'			=>$item['Item']['Sku'],
				'price'			=>floatval($item['Item']['Price']),
				'image'			=>'https://mylularoe.com/img/media/'.rawurlencode($model).'.jpg',
				'quantities'	=> array()); 
			}

			// Cut useless spaces
			$size = str_replace('/^ /','_',ltrim($size));

			// Set up the quantities of each size
			if (!isset($items[$model]['quantities'][$size])) 
			{
				$items[$model]['quantities'][$size] = $quantity;
			}			
		}

		if (!isset($items)) $items = [];

		// Sort alpha by model name
		usort($items, function($a, $b) {
				return strcmp($a["model"], $b["model"]);
			}
		);

		// Reorder this with numerical indeces
		foreach($items as $k=>$v) {
			$itemlist[$count++] = $this->arrangeByGirth($v);
		}

		return(Response::json($itemlist,200, array(), JSON_PRETTY_PRINT));
	}

	public function getInventory($key = '', $location='')
	{
		// Magic database voodoo
        $mbr	= self::getUserByKey($key);
		if ($mbr) $location = $mbr->first_name.' '.$mbr->last_name;

		// Get MAIN inventory as default
		if (empty($location) || (isset($mbr) && $mbr->id == 0)) // $key == 0 || $key == null)
		{
			$location = 'Main';

			// Return the user is able to log in, but shut out of MWL
			$key = Self::midauth(Config::get('site.mwl_username'), Config::get('site.mwl_password')); 
		}

		$server_output = '';

		// Generates the list of items from the product table per user
		//if (!empty($mbr) && $mbr->id > 0) {
		if (!empty($mbr)) {
			$p = Product::where('user_id','=',$mbr->id)->get(array('id','name','quantity','make','model','rep_price','size','sku','image'));
			$itemlist	= [];
			$count		= 0;

			foreach($p as $item) 
			{
				$quantity	= $item->quantity;
                // get product images
                $dbImage            = '';
                $attachment_images  = [];
                $attachments = Attachment::where('attachable_type', 'Product')->where('attachable_id', $item->id)->where('featured', 1)->get();
                foreach ($attachments as $attachment) {
                    $dbImage = Media::find($attachment->media_id);
					$dbImage->url = explode('.', $dbImage->url);
					if (isset($dbImage->url[1])) $dbImage->url = '/uploads/' . $dbImage->url[0] . '-sm.' . $dbImage->url[1];
                }

                $model      = $this->escapemodelname($item->name);
                $size       = $item->size;

				// Please keep the full https path in here it is for IOS
                $image      = (!empty($dbImage) && isset($dbImage->url)) ? $dbImage->url : 'https://mylularoe.com/img/media/'.rawurlencode($model).'.jpg';

				// Initialize this set of item data
				if (!isset($items[$model]))
				{
					$items[$model] = array(
					'model'			=>$model,
					'id'			=>$item->id,
					'UPC'			=>$item->sku,
					'SKU'			=>$item->sku,
					'price'			=>$item->rep_price,
					'image'			=>$image,
					'quantities'	=> array()); 
				}

				// Set up the quantities of each size
				if (!isset($items[$model]['quantities'][$size])) 
				{
					$items[$model]['quantities'][$size] = intval($quantity);
				}			

			}

			// Reorder this with numerical indeces
			if (isset($items)) {
				foreach($items as $k=>$v)
				{
					$itemlist[$count++] = $v;
				}
			}
			else $itemlist = null;

			return(Response::json($itemlist, 200, [], JSON_PRETTY_PRINT));
		}


		// Simple caching - probably a better way to do this
		if (!is_dir($this->mwl_cache)) @mkdir($this->mwl_cache);
		$mwlcachefile = $this->mwl_cache.urlencode($location).'.json';
		if (file_exists($mwlcachefile)) {
			$fs = stat($mwlcachefile);
			if (time() - $fs['ctime'] > $this->mwl_cachetime || filesize($mwlcachefile) < 500) {
				@unlink($mwlcachefile);
			}
			else {
				$server_output = file_get_contents($mwlcachefile);
			}
		}

		// Only pull from the inventory server 
		// if we don't have any output
		if (empty($server_output)) {
			// Pull this out into an actual class for MWL php api
			$location = rawurlencode($location);
			$ch = curl_init();

			// Set this to HTTPS TLS / SSL
			$curlstring = Config::get('site.mwl_api').'/llr/'.htmlentities($location,ENT_QUOTES,'UTF-8').'/inventorylist?sessionkey='.$key;
			curl_setopt($ch, CURLOPT_URL, $curlstring);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			if ($errno = curl_errno($ch)) {
				$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
				return(Response::json($result,401));
			}
			curl_close ($ch);
			file_put_contents($mwlcachefile, $server_output);
		}

		// Start transforming the server output data
		$output		= json_decode($server_output, true); // true = array
		$model		= '';
		$lastmodel	= '';
		$count		= 0;
		$itemlist	= [];

		if (empty($output)) { 
			// Last resort!
			$output = json_decode(file_get_contents($mwlcachefile));
			\Log::info('Nothing returned from inventory system!');
			//return Response::json(array('errors'=>true,'message'=>'Nothing returned from inventory system.'),500);
		}

        if(array_key_exists('Code',$output) && $output['Code'] == '400'){
			unlink($mwlcachefile);
            return Response::json(array('errors'=>true,'message'=> $output['Message'],'errno'=>'400'), 500);
        }

		// Transform the output to the appropriate IOS format
		foreach($output['Inventory'] as $item) 
		{

			$itemnumber = $item['Item']['Part']['Number'];
			$quantity	= $item['Item']['Quantity']['OnHand'];

			ltrim(rtrim($itemnumber));

			$model = preg_replace('/ -.*$/','',$item['Item']['Part']['Number']);

			// May want to ignore some inventory items here
			if (in_array(strtoupper($model), $this->ignore_inv)) {
				continue;
			}

			$itemList[$model] = '';
			
			// Delimiting sizes with hyphen and spaces
			if (strpos($itemnumber,' -') === false) 
			{
				$size  = 'NA';	
			}
			else list($model, $size) = explode(' -',$itemnumber);

			$model		= $this->escapemodelname($model);
			
			// Initialize this set of item data
			if (!isset($items[$model]))
			{
				$items[$model] = array(
				'model'			=>$model,
				'UPC'			=>$item['Item']['UPC'],
				'SKU'			=>$item['Item']['Sku'],
				'price'			=>floatval($item['Item']['Price']),
				'image'			=>'https://mylularoe.com/img/media/'.rawurlencode($model).'.jpg',
				'quantities'	=> array()); 
			}

			// Cut useless spaces
			$size = str_replace('/^ /','_',ltrim($size));

			// Set up the quantities of each size
			if (!isset($items[$model]['quantities'][$size])) 
			{
				$items[$model]['quantities'][$size] = $quantity;
			}			
		}

		if (!isset($items)) $items = [];

		// Sort alpha by model name
		usort($items, function($a, $b) {
				return strcmp($a["model"], $b["model"]);
			}
		);

		// Reorder this with numerical indeces
		foreach($items as $k=>$v) {
			$itemlist[$count++] = $this->arrangeByGirth($v);
		}

		return(Response::json($itemlist,200, array(), JSON_PRETTY_PRINT));
	}

	// Lovely Large Ladies Lambasted in Luxurious Linens
	public function arrangeByGirth($item) {
		$magnitude 		= array('XXS','XS','S','M','L','XL','XXL','XXXL','2XL','3XL');
		$orderedGirth	= array();

		// Sort by numeric size title
		if (!empty($item['quantities']))
		{
			uksort($item['quantities'], function($a, $b) {
					return(intval($a) > intval($b));
				}
			);
		}

		// Sort by TEXT size title
		foreach ($magnitude as $girth) {
			if (isset($item['quantities'][$girth])) 
				$orderedGirth[$girth] = $item['quantities'][$girth];
		}

		// Only return orderedGirth if we have put values in it
		if (!empty($orderedGirth)) $item['quantities'] = $orderedGirth;
		return($item);
	}

	public function getMwlUserInfo($user_id) {

        $mbr	= User::find($user_id);

		$key = Self::midauth();
		//return $key;
		$ch = curl_init();

		// Set to general auth for pulling inventory		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').''.Config::get('site.mwl_db')."/account?sessionkey=".$key."&username=".$mbr->id;

		curl_setopt($ch, CURLOPT_URL, $curlstring);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		if ($errno = curl_errno($ch)) {
			\Log::info('error in curl call');
			$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
			return(Response::json($result,401));
		}
		curl_close ($ch);

		if (!$server_output)
		{
			\Log::info('no output from server');
			return null;
		}
		else 
		{
			$so = json_decode($server_output);
			if (isset($so->Code) && $so->Code == '401')
			{
				\Log::info('server out put is 401');
				return null;
			}
			\Log::info('server output exists');
			return $so;
		}
	}

	public function createMwlUser($user_id,$password = null) {

		\Log::info("CreateMwlUser for [{$user_id} / {$password}]");

        $mbr = User::find($user_id);

		$bank_info = Bankinfo::where('user_id',$mbr->id)->first();
		//return $bank_info;
		$address = Address::where('addressable_id',$mbr->id)->first();

		// create a session key
		$key = Self::midauth();

		$ch = curl_init();

		// Set to general auth for creating records		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').''.Config::get('site.mwl_db')."/account?sessionkey=".$key;

		curl_setopt($ch, CURLOPT_URL, $curlstring);

		$headers = [];
		$headers[] = "Reseller-ID: 1";//.Self::getNextAvailableMid(); //for now
		$headers[] = "Merchant-Name: ".$mbr->first_name." ".$mbr->last_name;
		if(!empty($address->id))
		{
			//Hacky, I know
			$address_1 = (!empty($address->address_1))?$address->address_1:'';
			$city = (!empty($address->city))?$address->city:'';
			$state = (!empty($address->state))?$address->state:'';
			$zip = (!empty($address->zip))?$address->zip:'';
			$headers[] = "Merchant-Address: ".$address_1;
			$headers[] = "Merchant-City: ".$city;
			$headers[] = "Merchant-State: ".$state;
			$headers[] = "Merchant-Zip: ".$zip;
		}
		$headers[] = "Account-Type: checking"; // reqd (checking or saving)
		$headers[] = "Account-Name: ".$mbr->first_name." ".$mbr->last_name;
		$headers[] = "Account-Number:".@$bank_info->bank_account;
		$headers[] = "Account-Route: ".@$bank_info->bank_routing; //
		$headers[] = "Username: ".$mbr->id; //use the user->id for this
		$headers[] = "Password: ".self::midcrypt($password); //base 64 encoded password
		//return $headers;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		if ($errno = curl_errno($ch)) {
			\Log::error('Something went wrong to mwl system');
			$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
			return(Response::json($result,401));
		}
		curl_close ($ch);

		if (!$server_output) return(false);
		else {
			\Log::info('MWL Responded with: '.$server_output);
			$so = json_decode($server_output);
			if (isset($so->Code) && $so->Code == '401') return null;
			return($server_output);
		}
	}

	public function updateMwlUser($user_id,$password = null) {

        $mbr = User::find($user_id);

		$mwl_user = Self::getMwlUserInfo($mbr->id);
		if (!isset($mwl_user->Merchant->ID)) return $this->createMwlUser($user_id,$password);
		$merchant_id = $mwl_user->Merchant->ID;

		$address = Address::where('addressable_id',$mbr->id)->first();
		$bank_info = Bankinfo::where('user_id',$mbr->id)->first();
		if(!isset($bank_info->id)) return false;

		$key = Self::midauth();

		\Log::info("updateMwlUser for [{$user_id} / {$key}]");

		$ch = curl_init();

		// Set to general auth for creating records		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').''.Config::get('site.mwl_db')."/account?sessionkey=".$key;

		curl_setopt($ch, CURLOPT_URL, $curlstring);

		$headers = [];
		$headers[] = "Merchant-ID: ".$merchant_id; 
		$headers[] = "Merchant-Name: {$mbr->first_name} {$mbr->last_name}";
		if(!empty($address->id))
		{
			//Hacky, I know
			$address_1 = (!empty($address->address_1))?$address->address_1:'';
			$city = (!empty($address->city))?$address->city:'';
			$state = (!empty($address->state))?$address->state:'';
			$zip = (!empty($address->zip))?$address->zip:'';
			$headers[] = "Merchant-Address: ".$address_1;
			$headers[] = "Merchant-City: ".$city;
			$headers[] = "Merchant-State: ".$state;
			$headers[] = "Merchant-Zip: ".$zip;
		}
		if(!empty($bank_info->id))
		{
			$headers[] = "Account-Type: checking"; // reqd (checking or saving)
			$headers[] = "Account-Name: ".$mbr->first_name." ".$mbr->last_name;
			$headers[] = "Account-Number: ".$bank_info->bank_account;
			$headers[] = "Account-Route: ".$bank_info->bank_routing; //
		}
		$headers[] = "Username: ".$mbr->id; //use the user->id for this
		if(!empty($password))
		{
			$headers[] = "Password: ".self::midcrypt($password); //base 64 encoded password
		}

		\Log::info('Output: '.print_r($headers, true));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);
		//echo"<pre>"; print_r($server_output); echo"</pre>";
		//exit;
		if ($errno = curl_errno($ch)) {
			$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
			return(Response::json($result,401));
		}
		curl_close ($ch);

		file_put_contents('/tmp/test.txt',json_encode($headers));
		if (!$server_output) return(false);
		else {
			$so = json_decode($server_output);
			if (isset($so->Code) && $so->Code == '401') return null;
			\Log::info('Result: '.print_r($server_output, true));
			return($server_output);
		}
	}

	public function sendReceipt($key = '',  $repsale = true) {

		// First we fetch the Request instance
		$request = Request::instance();

		// Now we can get the content from it
		$content = $request->getContent();
		$vals = json_decode($content,true);

		// We should always have transaction IDS!
		if (!isset($vals['txids'])) return Response::json(array('error'=>true,'message'=>'Receipt invalid - no transactions?'), 500);

        \Log::info("[{$key}]".print_r($vals,true));

		if (empty($vals['err'])) $vals['err'] = 200;

		$invitems		= @$vals['products'];
		$auth			= @$vals['txids'];
		$sessiondata	= @$vals;

		// Wish we could use sessions on all this, thanks IOS!
        $user	= self::getUserByKey($key);

		// A new world order
		$o = new Order();
		$o->user_id         = $user->id;
		$o->total_price     = $vals['subtotal'];
		$o->total_points    = $vals['subtotal'];
		$o->total_tax       = $vals['tax'];
		$o->total_shipping  = 0;
		$o->details         = json_encode(array('orders'=>$invitems,'payments'=>$vals['txids']));
		$o->save();

		\Log::info('Creating new receipt');
		$inv = new Receipt();
		$inv->date_paid     = date('Y-m-d H:i:s');
		$inv->user_id       = $user->id;
		$inv->subtotal      = $vals['subtotal'];
		$inv->tax           = floatval($vals['tax']);
		$inv->balance       = 0;

		$inv->note          = isset($vals['notes'])          ? $vals['notes']         : '';
		$inv->to_email      = isset($vals['emailto'])        ? $vals['emailto']      : $user->email;
		$inv->to_firstname  = isset($vals['to_firstname'])   ? $vals['to_firstname']  : 'n/a';
		$inv->to_lastname   = isset($vals['to_lastname'])    ? $vals['to_lastname']   : 'n/a';

		$inv->data          = json_encode($invitems);
		$inv->save();

		\Log::info('Assigning ledger items to this receipt');
		foreach($vals['txids'] as $txn) {
			\Log::info("\t TXN:".$txn.' GOES INTO RECEIPT '.$inv->id);
			$l = Ledger::where('transactionid', '=', $txn)->update(array('receipt_id'=>$inv->id));
		}

		$result = array('error'=>false,'message'=>'Receipt Sent to '.$vals['emailto']);

		$orderitems	= [];
		if (!isset($vals['emailonly'])) {
			// Deduct item quantity from inventory
			foreach ($vals['products'] as $item) {
				foreach($item['quantities'] as $size=>$num)  {
					// Careful on this route 
					\Log::info("llrapi/v1/remove-inventory/{$key}/{$item['id']}/{$num}/");
					if ($item['id'] != Null) {
						$request    = Request::create("llrapi/v1/remove-inventory/{$key}/{$item['id']}/{$num}/",'GET', array());
						$deduction  = json_decode(Route::dispatch($request)->getContent());
					}
					else $result['deducted'][$item['id']] = false;//"Removed {$num} {$size} from {$item['id']}";
				}
			}
			$orderitems = $invitems;
		}
		else $result['deducted'] = [];

		$sessiondata['repsale']		= $repsale;
		$sessiondata['tax']			= $vals['tax'];
		$sessiondata['orderdata']	= $orderitems;
		$sessiondata['subtotal']	= $vals['subtotal'];
		$sessiondata['paidout']		= $vals['subtotal'] + $vals['tax'];

		$vals['discounts'] = (isset($vals['discounts'])) ? $vals['discounts'] : [];

		// Make the final receipt
		$receiptView	= View::make('inventory.validpurchase',compact('auth','invitems','sessiondata','user'));
		$receipt		= $receiptView->renderSections();

        $receipt		= $receipt['manifest'];
		$data			= [];
		$data['email']	= $vals['emailto'];
		$data['body'] 	= preg_replace('/\s\s+/', ' ',$receipt);

		if (!empty($data['email'])) {
			try { 
				$data['email'] = str_replace(' ','',preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$data['email']));
				\Log::info('Dispatching final email receipt to: '.$data['email']);
				// This one goes to the final user
				Mail::send('emails.standard', array('data'=>$data,'user'=>$user,'message'=>$data['body'],'body'=>$data['body']), function($message) use($user, $data) {
					$message->to($data['email'])
					->subject('Order receipt from '.$user->first_name.' '.$user->last_name)
					->from($user->email, $user->first_name.' '.$user->last_name);
				});
			}
			catch (Exception $e) {
				$result['message'] = $e->getMessage();
			}
		} else $result['message'] = 'No receipt sent: Please specify an email address.';

		return Response::json($result, $vals['err']);
	}

	public function getNextAvailableMid() {
		return 1;
	}

	public function getAccountType($type = 'Checking') {
		return 1;
	}

	public function setmwlpassword($id, $pass, $cid = 'llr') {
		$cid = $this->mwl_db;

		try {
			$mysqli = new mysqli(self::MWL_SERVER, self::MWL_UN, self::MWL_PASS, self::MWL_DB);
		}
		catch (Exception $e)
		{
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return(Response::json($noconnect, 500));
		}

		$pwd = base64_encode(md5($pass,true));
		$pwdf = base64_encode(md5($cid.$pwd,true));
		$Q = "INSERT INTO users SET id='{$id}', username='{$id}', password='{$pwdf}' ON DUPLICATE KEY UPDATE password='{$pwdf}'";
		$res = $mysqli->query($Q);

		$mysqli->close();
		return($res);
	}


	// It is this way until we have proper api access to the ledger.
	public function ledger($key = 0) {

		$mbr = $this->getUserByKey($key);
		if (!$mbr) return Response::json(array('error'=>'true','message'=>'Please login again.'),401);
		\Log::info("Getting Ledger Items for {$mbr->id} [{$key}]");

		$ref = Input::get('ref', null);
		$key = Session::get('mwl_id', $key);

		//$txns = $this->getLedger($mbr->id, $ref);

		// This will barf on ammons user
		return Response::json($this->getLedger($mbr->id, $ref),200,[],JSON_PRETTY_PRINT);


		try {
			$mysqli = new mysqli(self::MWL_SERVER, self::MWL_UN, self::MWL_PASS, self::MWL_DB);
		}
		catch (Exception $e)
		{
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return(Response::json($noconnect,200));
		}
	
		// This is not good .. WHERE'S MY API!
		$Q = "SELECT tid, refNum as order_number, result, authAmount as subtotal, salesTax as tax,  cashsale, processed, refunded FROM transaction LEFT JOIN sessionkey ON(userid=tid) WHERE `key`='".$mysqli->escape_string($key)."'";
		if ($ref != null) $Q .= " AND refNum='".intval($ref)."' LIMIT 1";

		$txns		= [];
		$stub_items = [];

		$res = $mysqli->query($Q);
		while($txn = $res->fetch_assoc())
		{
			$ordernum = $txn['order_number'];
			if (!isset($stub_items["".$ordernum])) 
			{
				$l = Ledger::where('transactionid', '=', $ordernum)->get(array('data'))->first();
				if ($l) {
					$stub_items[$ordernum] = json_decode($l->data);
				}
				else $stub_items[$ordernum] = array();
			}
			$txn['items'] = $stub_items["".$ordernum];
			$txns[] = $txn;
		}	
		$mysqli->close();

		return(Response::json($txns, 200, [], JSON_PRETTY_PRINT));
	}

	// I have to have this here because I don't want mysql credentials all over the place .. sorry
	// This for now until we have an api in place
	public function getLedger($id = 0, $ref = null)
	{
        $currentuser	= User::find($id);

		try {
			$mysqli = new mysqli(self::MWL_SERVER, self::MWL_UN, self::MWL_PASS, self::MWL_DB);
		}
		catch (Exception $e)
		{
			return json_encode(array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage()));
			//return(Response::json($noconnect,200));
		}
	

/* 
SELECT to_email,transaction.refNum as order_number, transaction.authAmount AS amount, transaction.salesTax AS tax, transaction.custNum AS customer, transaction.cashsale AS is_cash, transaction.refunded AS is_refunded, transaction.created_at AS date, users.username AS username, tid.id AS tid, accounts.name AS account FROM users LEFT JOIN tid ON users.id=tid.id LEFT JOIN accounts ON accounts.id=tid.account LEFT JOIN transaction ON transaction.tid=tid.id LEFT JOIN llr_web.ledger on transaction.refNum=llr_web.ledger.transactionid LEFT JOIN llr_web.receipts ON llr_web.ledger.receipt_id=llr_web.receipts.id WHERE users.username='{$currentuser->id}' ORDER BY transaction.created_at DESC
*/
		// This is not good .. WHERE'S MY API!
		$Q = "SELECT 	
					transaction.refNum as order_number,
					transaction.authAmount AS amount,
					transaction.salesTax AS tax,
					transaction.custNum AS customer,
					transaction.cashsale AS is_cash,
					transaction.refunded AS is_refunded,
					transaction.created_at AS date,
					users.username AS username,
					tid.id AS tid,
					accounts.name AS account 
				FROM users LEFT JOIN tid 
					ON users.id=tid.id LEFT JOIN accounts 
					ON accounts.id=tid.account LEFT JOIN transaction 
					ON transaction.tid=tid.id 
				WHERE users.username='{$currentuser->id}' ORDER BY created_at DESC";
		if ($ref != null) $Q .= " AND refNum='".intval($ref)."' LIMIT 1";

		$txns		= [];
		$stub_items = [];

		/*
		"tid": "10412",
        "order_number": "1041200055",
        "result": "Approved",
        "subtotal": "12.06",
        "tax": "0",
        "cashsale": "1",
        "processed": "1",
        "refunded": "0",
		*/
		$res = $mysqli->query($Q);

		while($txn = $res->fetch_assoc())
		{
			//$txn['date'] = date('M d Y H:i:s',strtotime($txn['date']));
			$txn['date'] = date('Y-m-d\TH:i:sO',strtotime($txn['date']));
			$ordernum = $txn['order_number'];
			$txn['amount'] = ''.money_format('%2n', $txn['amount']);
			$txn['is_cash'] = (bool)$txn['is_cash'];
			$txn['is_refunded'] = (bool)$txn['is_refunded'];

			if ($id == 11950) {
				$stub_items[$ordernum][0]  = array(
							'model'			=>'Test - Disregard',
							'id'			=>1,
							'UPC'			=>null,
							'SKU'			=>null,
							'price'			=>50,
							'image'			=>'https://mylularoe.com/img/media/Maxi.jpg',
							'quantities'	=> ['M'=>1,'L'=>2]);
			}

			if (!isset($stub_items[$ordernum])) 
			{
				$stub_items[$ordernum] = [];
/*
				$l = Ledger::where('transactionid', '=', $ordernum)->get(array('data'))->first();
				if ($l) {
					$stub_items["".$ordernum] = json_decode($l->data);
				}
				else $stub_items["".$ordernum] = array();
*/
			}
			$txn['items'] = $stub_items[$ordernum];

			$txns[] = $txn;
		}	
		$mysqli->close();
		return $txns;
		//	return(Response::json($txns, 200, [], JSON_PRETTY_PRINT));
	}

	// Keep these separate for now
	public function refund($key = 0)
	{
		//does this session key correlate with the TID?

		$txdata = array(
			'transactionId'     => Input::get('transactionid'),
			'Subtotal'          => floatval(Input::get('subtotal')),
			'Tax'               => floatval(Input::get('tax')),
			'Account-name'      => Input::get('cardname'),
			'Card-Number'       => Input::get('cardnumber'),
			'Card-Code'     	=> Input::get('cardcvv'),
			'Card-Expiration'   => Input::get('cardexp'),
			'Card-Address'      => Input::get('cardaddress'),
			'Card-Zip'          => Input::get('cardzip'),
		);

		foreach($txdata as $k=>$v) {
			$txheaders[] = "{$k}: {$v}";
		}

        $refund = self::makeRefund($key, $txheaders, Input::get('transactionid'));

		return($refund);
	}
/*
{
        “cash” : 50
        “tax” : 10
        “subtotal” : 100
        “total” : 110
        “cards” : [
                {
                        … card stuff, exp, card no. etc. ..
                        “amount” : 50
                },
                {
                        … card stuff, exp, card no. etc. …
                        “amount” : 10
                }
        ]
        “items_sold” : [
                {
                        “model” : “example”,
                        “price” : 100
                        “quantitates” : {
                                “XL” : 1
                        }
                }
        ]
}
*/

	public function multiPurchase($key = 0, $cart = '')
	{
		foreach(Input::get('payments') as $payment) {

		}

	}

	public function purchase($key = 0, $cart = '') {

		$cartdata	= Input::all();
		$endpoint	= '';

		// Move this below crossouts once no need for monitoring
        \Log::info("[{$key}] Purchasing cart full of ".json_encode($cartdata));

		if (isset($cartdata['cardname'])) {
			$cartdata['cardnumber'] = 'xxxx-xxxx-xxxx-'.substr(@$cartdata['cardnumber'],-4);
			unset($cartdata['cardcvv']);
			unset($cartdata['cardpin']);
			$cartdata['cardexp']	= @$cartdata['cardexp'];
			$cartdata['cardzip']	= @$cartdata['cardzip'];
		}
		if (isset($cartdata['routing'])) {
			$cartdata['routing']	= 'xxxxxxx'.substr(@$cartdata['rounting'],-4);
			$cartdata['account']	= 'xxxxxxx'.substr(@$cartdata['account'],-4);
		}

		// If this is a taxless purchase such as consignment
		if (empty(Input::get('tax')) || Session::has('notax')) {
			Input::merge(array('tax'=>0));
		}

		if 		(Input::get('cash')) 	$txtype = 'CASH';
		elseif	(Input::get('check'))	$txtype = 'ACH';
		else 							$txtype = 'CARD';

		// Wish we could use sessions on all this, thanks IOS!
        if (Session::has('repsale') && !Session::get('repsale'))  {
            $mbr    = User::find(Config::get('site.mwl_username')); // Use 0 user info
        }
        else {
            $mbr    = self::getUserByKey($key);
        }


		// Set up appropraite transaction headers
		if ($txtype == 'CARD') {
			$txdata = array(
				'Subtotal'          => floatval(Input::get('subtotal',0)),
				'Tax'               => floatval(Input::get('tax',0)),
				'Account-name'      => Input::get('cardname'),
				'Card-Number'       => Input::get('cardnumber'),
				'Card-Code'     	=> Input::get('cardcvv'),
				'Card-Expiration'   => Input::get('cardexp'),
				'Card-Address'      => Input::get('cardaddress'),
				'Card-Zip'          => Input::get('cardzip'),
				'Description'       => 'SEE INVOICES' // json_encode($cartdata)
			);
			$endpoint = 'sale';
			foreach($txdata as $k=>$v) {
				$txheaders[] = "{$k}: {$v}";
			}
		}
		else if ($txtype == 'CASH') {
			$txdata = array(
				'Subtotal'          => floatval(Input::get('subtotal',0)),
				'Tax'               => floatval(Input::get('tax',0)),
				'Description'       => 'SEE INVOICES'//json_encode($cartdata)
			);
			$endpoint = 'cash';
			foreach($txdata as $k=>$v) {
				$cashparameters = array('Tax','Subtotal','Description');
				if (in_array($k, $cashparameters)) $txheaders[] = "{$k}: {$v}";
			}
		}
		else if ($txtype == 'ACH') {
			$txdata = array(
				'Account-Name' 		=> Input::get('accountname'),
				'Routing-Number' 	=> Input::get('routing'),
				'Account-Number' 	=> Input::get('account'),
				'License-State' 	=> Input::get('dlstate'),
				'License-Number' 	=> Input::get('dlnum'),
				'Check-Number' 		=> Input::get('checknum'),
				'Subtotal'          => floatval(Input::get('subtotal',0)),
				'Tax'               => floatval(Input::get('tax',0)),
				'Description'       => 'SEE INVOICES'//json_encode($cartdata)
			);
			$endpoint = 'checkSale';
			foreach($txdata as $k=>$v) {
				$txheaders[] = "{$k}: {$v}";
			}
		}

		$purchase = self::makePayment($key, $txheaders, $endpoint);

		// Drop this into product table too.
		if (!$purchase['error']) {

			\Log::info("Dropping into ledger for [{$key}]");

			$lg = new Ledger();
			$lg->user_id		= @$mbr->id;
			$lg->account		= '';
			$lg->amount			= Input::get('subtotal',0);
			$lg->tax			= Input::get('tax',0);
			$lg->txtype			= $txtype; 
			$lg->transactionid	= $purchase['id'];
			$lg->data			= json_encode($cartdata);
			$lg->save();

		}

        return Response::json($purchase, 200);
	}

    private static function midcrypt($pass, $cid = 'llr', $level = 1)
    {
		if ($level == 1) return base64_encode(md5($pass,true));
        return base64_encode(md5($cid.base64_encode(md5($pass,true)),true));
    //    return base64_encode(md5($pass,true));
    }

	/*##############################################################################################
	MiddleWare Authentication
	##############################################################################################*/
	
	public function midauth($username = '', $password = '', $returnJson = false) {
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set to general auth for pulling inventory
		if (empty($username) && empty($password))
		{
			$username = urlencode(Config::get('site.mwl_username'));
			$password = urlencode(Config::get('site.mwl_password'));
		}

		$password = Self::midcrypt($password);

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').''.Config::get('site.mwl_db')."/login/?username={$username}&password=".rawurlencode($password);
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		/* If we ever decide to 'POST'
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username={$username}&password={$password}");
		*/

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		if ($errno = curl_errno($ch)) {
			$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Something went wrong connecting to mwl system.','errno'=>$errno);
			return(Response::json($result,401));
		}
		curl_close ($ch);

		if (is_array(json_decode($server_output,true))) {
			$result = array('errors'=>true,'url'=>$curlstring,'message'=> 'Account validaton required.','errno'=>$errno);
			return(Response::json($result,401));
		}

		$returnthis = ($returnJson) ? json_encode(['key'=>$server_output]) : $server_output;

		\Log::info("Midauth {$username} / {$password} : {$server_output} / {$returnthis}");

		if (!$server_output) return(false);
		else {
			if ($returnJson) 
			$so = json_decode($server_output);
			if (isset($so->Code) && $so->Code == '401') $returnthis = ($returnJson) ? json_encode(['key'=>null]) : null;
		}
		return $returnthis;
	}

	private function makeVoid($key, $txdata) {
		// Whether or not to write to /tmp/request.txt for debuggification
		$verbose = true; 

		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/'.Config::get('site.mwl_db')."/payment/void?sessionkey=".Session::get('mwl_id', $key);
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $txdata);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($verbose)
		{
			$f = fopen('/tmp/request.txt', 'w');
			curl_setopt_array($ch, array(
				CURLOPT_VERBOSE        => 1,
				CURLOPT_STDERR         => $f,
			));
		}

		$server_output = curl_exec ($ch);
		$response_obj = json_decode($server_output);

		/* CREATE UNIFIED OBJECT FOR ALL RESPONSE PERMUTATIONS
		// Having to make concession for no "transactionresponse" that is
		// may be returned from MWL during sessionkey auth or during 
		// card decline
		*/
		$raw_response = $response_obj;
		if (!isset($response_obj->TransactionResponse)) {
			// unset($response_obj);
			// $response_obj = new stdClass();
			$response_obj->TransactionResponse = new stdClass();
			$response_obj->TransactionResponse->Error = true;
		}

		if (isset($response_obj->Code)) {
			$response_obj->TransactionResponse->Result		= 'key mismatch';
			$response_obj->TransactionResponse->ResultCode	= 'K';
			$response_obj->TransactionResponse->Status		= 'Declined';
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}

		// Having to transform this since what is returned is not in a uniform format!!

		// Bug Mike Carpenter about this .. :-)
		if (isset($response_obj->Status)) { 
			if ($response_obj->Status == 'Failed'){
				$response_obj->TransactionResponse->Result		= 'Declined';
				$response_obj->TransactionResponse->ResultCode	= 'F';
				$response_obj->TransactionResponse->Status		= 'Void Failed';
				$response_obj->TransactionResponse->AuthAmount	= 0;
			}
			else if ($response_obj->Status == 'Success') {
				$response_obj->TransactionResponse->Result		= 'Voided';
				$response_obj->TransactionResponse->ResultCode	= 'V';
				$response_obj->TransactionResponse->Status		= 'Voided';
				$response_obj->TransactionResponse->AuthAmount	= floatval(Input::get('subtotal')) + floatval(Input::get('tax'));
			}
		}

		// If something really fscked
		if (!isset($response_obj->TransactionResponse->ResultCode)) {
			$response_obj->data = $raw_response;
		}

		// We're authorized!
		if (isset($response_obj->TransactionResponse->ResultCode) && $response_obj->TransactionResponse->ResultCode == 'A') {
			$response_obj->TransactionResponse->Error = false;
		}

        return Response::json(array('error'=>$response_obj->TransactionResponse->Error,
									'result'=>$response_obj->TransactionResponse->Result, 
									'status'=>$response_obj->TransactionResponse->Status,
									'amount'=>$response_obj->TransactionResponse->AuthAmount,
									'data'=>$raw_response),200);
	}

	private function makeRefund($key, $txdata = array()) {
		// Whether or not to write to /tmp/request.txt for debuggification
		$verbose = true; 

		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/'.Config::get('site.mwl_db')."/payment/credit?sessionkey=".Session::get('mwl_id', $key);
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $txdata);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($verbose)
		{
			$f = fopen('/tmp/request.txt', 'w');
			curl_setopt_array($ch, array(
				CURLOPT_VERBOSE        => 1,
				CURLOPT_STDERR         => $f,
			));
		}

		$server_output = curl_exec ($ch);
		$response_obj = json_decode($server_output);

		// Handle wonky error messages
		if (isset($response_obj->Status)) {
			switch ($response_obj->Error->Code) {
				// Transaction needs to be voided
				case 115 : return($this->makeVoid($key, $txdata));
			}
		}

		/* CREATE UNIFIED OBJECT FOR ALL RESPONSE PERMUTATIONS
		// Having to make concession for no "transactionresponse" that is
		// may be returned from MWL during sessionkey auth or during 
		// card decline
		*/
		$raw_response = $response_obj;
		if (!isset($response_obj->TransactionResponse)) {
			// unset($response_obj);
			// $response_obj = new stdClass();
			$response_obj->TransactionResponse = new stdClass();
			$response_obj->TransactionResponse->Error = true;
		}

		if (isset($response_obj->Code)) {
			$response_obj->TransactionResponse->Result		= 'key mismatch';
			$response_obj->TransactionResponse->ResultCode	= 'K';
			$response_obj->TransactionResponse->Status		= 'Declined';
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}

		// Having to transform this since what is returned is not in a uniform format!!

		// Bug Mike Carpenter about this .. :-)
		if (isset($response_obj->Status) && $response_obj->Status == 'D' || isset($response_obj->Error)) {
			$response_obj->TransactionResponse->Result		= 'Declined';
			$response_obj->TransactionResponse->ResultCode	= 'D';
			$response_obj->TransactionResponse->Status		= 'Declined';
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}

		// If something really fscked
		if (!isset($response_obj->TransactionResponse->ResultCode)) {
			$response_obj->data = $raw_response;
		}

		// We're authorized!
		if (isset($response_obj->TransactionResponse->ResultCode) && $response_obj->TransactionResponse->ResultCode == 'A') {
			$response_obj->TransactionResponse->Error = false;
		}

        return Response::json(array('error'=>$response_obj->TransactionResponse->Error,
									'result'=>$response_obj->TransactionResponse->Result, 
									'status'=>$response_obj->TransactionResponse->Status,
									'amount'=>$response_obj->TransactionResponse->AuthAmount,
									'data'=>$raw_response),200);
	}

	private function makeFakery($txdata = '') {
		$fake		 = false;
		$fk = json_encode($txdata);

		if (preg_match('/Matthew Frederico|Ken Barlow/',$fk)) {
			$fake = true;
			\Log::info('FAKERY: '.(($fake) ? 'TRUE' : 'FALSE'));
		}

		return($fake);
	}

	private function makePayment($key, $txdata = array(), $type='sale') {

        if ($this->makeFakery($txdata)) {
            $returndata = array('error'=>false,
                    'result'=>'Approved',
                    'status'=>'Settled',
                    'amount'=>'0',
                    'id'    => 'FAKE',
                    'data'  => 'FAKE');
            return($returndata);
        }


		// Whether or not to write to /tmp/request.txt for debuggification
		$verbose = false; 

		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/'.Config::get('site.mwl_db')."/payment/{$type}?sessionkey=".Session::get('mwl_id', $key);
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $txdata);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($verbose)
		{
			$f = fopen('/tmp/request.txt', 'w');
			curl_setopt_array($ch, array(
				CURLOPT_VERBOSE        => 1,
				CURLOPT_STDERR         => $f,
			));
		}

		$server_output = curl_exec ($ch);
		$response_obj = json_decode($server_output);

		/* CREATE UNIFIED OBJECT FOR ALL RESPONSE PERMUTATIONS
		// Having to make concession for no "transactionresponse" that is
		// may be returned from MWL during sessionkey auth or during 
		// card decline
		*/
		$raw_response = $response_obj;

		\Log::info('SERVER INPUT TXN: '.$curlstring.print_r($txdata,true));
		\Log::info('SERVER OUTPUT TXN: '.print_r($server_output,true));

		if (!isset($response_obj->TransactionResponse)) {
			$response_obj = new stdClass();
			$response_obj = $raw_response;
			$response_obj->TransactionResponse = new stdClass();
			$response_obj->TransactionResponse->Error = true;
		}

		if (isset($response_obj->Status)) { 
			if ($response_obj->Status == 'Failed'){
				$response_obj->TransactionResponse->Result		= 'Declined';
				$response_obj->TransactionResponse->ResultCode	= 'F';
				$response_obj->TransactionResponse->Status		= 'Attempt Failed';
				$response_obj->TransactionResponse->AuthAmount	= 0;
			}
			if ($response_obj->Status == 'Error'){
				$response_obj->TransactionResponse->Result		= 'Declined';
				$response_obj->TransactionResponse->ResultCode	= $response_obj->Error->Code;
				$response_obj->TransactionResponse->Status		= $response_obj->Error->Description;
				$response_obj->TransactionResponse->AuthAmount	= 0;
			}
		}

		if (isset($response_obj->Code)) {
			$response_obj->TransactionResponse->Result		= 'key mismatch';
			$response_obj->TransactionResponse->ResultCode	= 'K';
			$response_obj->TransactionResponse->Status		= 'Declined';
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}

		if (isset($response_obj->Error)) {
			$response_obj->TransactionResponse->Result = 'Declined';
			$response_obj->TransactionResponse->ResultCode	= $response_obj->Error->Code;
			$response_obj->TransactionResponse->Status		= $response_obj->Error->Description;
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}
			
		// Having to transform this since what is returned is not in a uniform format!!
		// Bug Mike Carpenter about this .. :-)
		if (isset($response_obj->Status) && $response_obj->Status == 'D') {
			$response_obj->TransactionResponse->Result		= 'Declined';
			$response_obj->TransactionResponse->ResultCode	= 'D';
			$response_obj->TransactionResponse->Status		= 'Declined';
			$response_obj->TransactionResponse->AuthAmount	= 0;
		}

		// We're authorized!
		if ($response_obj->TransactionResponse->ResultCode == 'A') {
			$response_obj->TransactionResponse->Error = false;
		}

        $returndata = array('error'=>$response_obj->TransactionResponse->Error,
							'result'=>$response_obj->TransactionResponse->Result, 
							'status'=>$response_obj->TransactionResponse->Status,
							'amount'=>$response_obj->TransactionResponse->AuthAmount,
							'data'=>$raw_response);

		$returndata['id'] = (isset($response_obj->TransactionResponse->ID))  ? $response_obj->TransactionResponse->ID  : null;
		$returndata['id'] = (string)$returndata['id'];

        return ($returndata);
	}

	public function auth($login, $pass = '') {
		$pass	= trim(Input::get('pass', $pass));
        $status = 'ERR';
        $error  = false;
		$data   = [];

		// Initialize these two
		$tstamp		= 0;
		$sessionkey = '';

		 // Find them here 5.2.0 feature filter_var
		if (filter_var($login,FILTER_VALIDATE_EMAIL)) {
			$mbr = User::where('email', '=', $login)->where('disabled', '=', '0')->get(array('id', 'email', 'key', 'password', 'first_name', 'last_name', 'image','public_id'))->first();
		}
		else {
			$mbr = User::where('id', '=', $login)->where('disabled', '=', '0')->get(array('id', 'email', 'key', 'password', 'first_name', 'last_name', 'image','public_id'))->first();
		}
		//$mbr->password_entered = $pass;
		//return $mbr;
        // Can't find them?
        if (!isset($mbr)) {
			$error = true;
            $mbr	= null;
            $status = 'User '.strip_tags($login).' not found';
        }
		elseif($attempt = \Auth::attempt(['email' => $mbr->email,'password' => $pass], false))
		{
			$status = 'User '.strip_tags($login).' found ok';
			$data = array(
				'id'			=> $mbr->id,
				'public_id'		=> $mbr->public_id,
				'first_name'	=> $mbr->first_name,
				'last_name'		=> $mbr->last_name,
				'image'			=> $mbr->image,
				'key'			=> $mbr->key,
				'email'			=> $mbr->email
			);

			if (!empty($mbr->key)) @list($sessionkey, $tstamp) = explode('|',$mbr->key);

			// 3 minutes timeout for session key - put this in a Config::get('site.mwl_session_timeout')!
			if (empty($sessionkey) || $tstamp < (time() - $this->SESSIONKEY_TIMEOUT))
			{
				\Log::info("User {$mbr->id} / {$pass} ".date('Y-m-d H:i:s',$tstamp)." MWL - timeout or login need them to change password?");
				// Return the user is able to log in, but shut out of MWL

				// If we use the 'key' parameter, we could feasibly have 
				// Multiple acconts using 1 TID .. Feature?
				$sessionkey = Self::midauth($mbr->id, $pass);

				//return $sessionkey;
				$tstamp		= time();

				if (!$sessionkey) {
					$error = true;
					\Log::info("Cannot get key from MWL {$mbr->id} / {$pass} ".date('Y-m-d H:i:s',$tstamp)." MWL - need them to change password?");
					$status .= '; cannot retrieve key from payment system';
					$data['key'] = null;

					// Also perform a logging notify here in papertrail or syslog?
				}
				else {
					$mbr->update(array('key'=>$sessionkey.'|'.time()));
				}
			}
		}
		else
		{
			$error = true;
			\Log::info("Cannot authorize {$mbr->id} / {$pass}");
			$status = 'Cannot authorize';
			$mbr->update(array('key'=>''));
		}

		// Set session key to null 
		if (empty($sessionkey)) $sessionkey = null;
		
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data,'mwl'=>$sessionkey),($error) ? 401 : 200);

	}

	// This is a SHIV .. I mean SHIM for angular to do its magic
    public function reorder(){
        $data = Input::all();
        if(empty($data) || empty($data['orderdata'])) {
            $message = "No data posted";
            $status = "fail";    
        } else {
			Session::put('orderdata',$data['orderdata']);
			Session::put('cartdata',$data);

            $message = "Successfully posted data";
            $status = "success"; 
        }
        return Response::json(['message'=>$message,'status'=>$status,'data'=>$data], 200);
    }
	
	// This is a SHIV .. I mean SHIM for angular to do its magic
    public function reorderx(){
        $data = Input::all();
        if(empty($data)) {
            $message = "No data posted";
            $status = "fail";    
        }else{
			Session::put('orderdata',$data);
            $message = "Successfully posted data";
            $status = "success"; 
        }
        return Response::json(['message'=>$message,'status'=>$status,'data'=>$data], 200);
    }

}
