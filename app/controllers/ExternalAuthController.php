<?php

class ExternalAuthController extends \BaseController {

	// Private vars for this controller only
	private $mwl_server	= 'mwl.controlpad.com';
	private $mwl_un		= 'llr_txn';
	private $mwl_pass	= 'ilovetexas';
	private $mwl_db		= 'llr';
	private $mwl_cachetime	= 3600;
	private	$mwl_cache	= '../app/storage/cache/mwl/';

	// These items are to be ignored and not shown
	private $ignore_inv	= ['OLIVIA', 'NENA & CO.', 'DDM SLEEVE', 'DDM SLEEVELESS'];
	public 	$logdata = false;

	// STUB for removing inventory
	public function rmInventory($key,$id,$quan) {
		// Magic database voodoo
        $mbr	= User::where('key', 'LIKE', $key.'|%')->first();
		
		$prod = Product::where('user_id','=',$mbr->id)->where('id','=',$id)->get()->first();

		if (!empty($prod)) { 
			if ($prod->quantity >= intval($quan)+1) {
				$prod->quantity = $prod->quantity - intval($quan);
				$prod->save();
				return(Response::json(array('error'=>false,'message'=>'success','remaining'=>intval($prod->quantity),'attempted'=>$quan),200));
			}
			else {
				return(Response::json(array('error'=>true,'message'=>'fail','remaining'=>intval($prod->quantity),'attempted'=>$quan),200));
			}
		}
		else {
			return(Response::json(array('error'=>true,'message'=>'Item not found'),200));
		}

	}

	public function getInventory($key = 0, $location='')
	{
		// Magic database voodoo
        $mbr = User::where('key', 'LIKE', $key.'|%')->first();
		if ($mbr) $location = $mbr->first_name.' '.$mbr->last_name;

		if ($this->logdata) file_put_contents('/tmp/logData.txt','OKey: '.$key."\n",FILE_APPEND);
		if ($this->logdata) file_put_contents('/tmp/logData.txt','OLoc: '.$location."\n",FILE_APPEND);

		// Get MAIN inventory as default
		if (empty($location)) // $key == 0 || $key == null)
		{
			$location = 'Main';

			// Return the user is able to log in, but shut out of MWL
			$key = Self::midauth(); // stub parameters
		}

		if ($this->logdata) file_put_contents('/tmp/logData.txt','TKey: '.$key."\n",FILE_APPEND);
		if ($this->logdata) file_put_contents('/tmp/logData.txt','TLoc: '.$location."\n",FILE_APPEND);

		$server_output = '';

		// Generates the list of items from the product table per user
		if (!empty($mbr) && $mbr->id > 0) {
			$p = Product::where('user_id','=',$mbr->id)->get(array('id','name','quantity','make','model','rep_price','size','sku','image'));
			$itemlist	= [];
			$count		= 0;

			foreach($p as $item) 
			{
				$quantity	= $item->quantity;
				$model		= $item->name;
				$image 		= (!empty($item->image)) ? $item->image : 'https://mylularoe.com/img/media/notfound.jpg';
				$size		= $item->size;

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
					$items[$model]['quantities'][$size] = $quantity;
				}			

			}

			// Reorder this with numerical indeces
			foreach($items as $k=>$v)
			{
				$itemlist[$count++] = $v;
			}

			return(Response::json($itemlist,200));
		}


		// Simple caching - probably a better way to do this
		@mkdir($this->mwl_cache);
		$mwlcachefile = $this->mwl_cache.urlencode($location).'.json';
		if ($this->logdata) file_put_contents('/tmp/logData.txt','File: '.$mwlcachefile."\n",FILE_APPEND);
		if (file_exists($mwlcachefile)) {
			$fs = stat($mwlcachefile);
			if (time() - $fs['ctime'] > $this->mwl_cachetime) {
				unlink($mwlcachefile);
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
				$result = array('errors'=>true,'message'=> 'Something went wrong connecting to inventory system.','errno'=>$errno);
				return(Response::json($result,200));
				die();
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

        if(array_key_exists('Code',$output) && $output['Code'] == '400'){
			unlink($mwlcachefile);
            print json_encode(array('errors'=>true,'message'=> $output['Message'],'errno'=>'400'));
            return(false);
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

			// Initialize this set of item data
			if (!isset($items[$model]))
			{
				$items[$model] = array(
				'model'			=>$model,
				'UPC'			=>$item['Item']['UPC'],
				'SKU'			=>$item['Item']['Sku'],
				'price'			=>$item['Item']['Price'],
				'image'			=>'https://mylularoe.com/img/media/'.rawurlencode($model).'.jpg',
				'quantities'	=> array()); 
			}

			// Cut useless spaces
			$size = ltrim($size); // str_replace('/^ /','',$size);

			// Set up the quantities of each size
			if (!isset($items[$model]['quantities'][$size])) 
			{
				$items[$model]['quantities'][$size] = $quantity;
			}			
		}

		if (!isset($items)) $items = [];

		// Reorder this with numerical indeces
		foreach($items as $k=>$v)
		{
			$itemlist[$count++] = $this->arrangeByGirth($v);
		}

		//print json_encode($itemlist, JSON_PRETTY_PRINT);
		return(Response::json($itemlist,200));
		// STUB
//		return(file_get_contents('SampleInventory.json'));
	}

	// Lovely Large Ladies Lambasted in Luxurious Linens
	public function arrangeByGirth($item) {
		$magnitude 		= array('XXS','XS','S','M','L','XL','XXL','XXXL','2XL','3XL');
		$orderedGirth	= array();

		foreach ($magnitude as $girth) {
			if (isset($item['quantities'][$girth])) 
				$orderedGirth[$girth] = $item['quantities'][$girth];
		}
		if (!empty($orderedGirth)) $item['quantities'] = $orderedGirth;
		return($item);
	}

	// What is this hackery?!
	// PLEASE baby Jesus, lets get an api for these things.
	public function setmwlpassword($id, $pass, $cid = 'llr') {
		$cid = $this->mwl_db;

		try {
			$mysqli = new mysqli($this->mwl_server, $this->mwl_un, $this->mwl_pass, $this->mwl_db);
		}
		catch (Exception $e)
		{
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return(Response::json($noconnect,200));
		}

		$pwd = base64_encode(md5($pass,true));
		$pwdf = base64_encode(md5($cid.$pwd,true));
		$Q = "REPLACE INTO users SET username='{$id}', password='{$pwdf}'";
		$res = $mysqli->query($Q);

		$mysqli->close();
		return($res);
	}

	// It is this way until we have proper api access to the ledger.
	public function ledger($key = 0)
	{
		$ref = Input::get('ref');
		$key = Session::get('mwl_id', $key);

		try {
			$mysqli = new mysqli($this->mwl_server, $this->mwl_un, $this->mwl_pass, $this->mwl_db);
		}
		catch (Exception $e)
		{
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return(Response::json($noconnect,200));
		}
	
		// This is not good .. WHERE'S MY API!
		$Q = "SELECT tid, refNum as order_number, result, authAmount as subtotal, salesTax as tax,  cashsale, processed, refunded FROM transaction LEFT JOIN sessionkey ON(userid=tid) WHERE `key`='".$mysqli->escape_string($key)."'";
		if ($ref != null) $Q .= " AND refNum='".intval($ref)."' LIMIT 1";

		$txns = [];

		// Pull these from inventory data
		$stub_items = json_decode('[{"quantities":{"M":2,"L":3,"XXS":5},
									"price":59.99,
									"image":"http://mylularoe.com/img/media/Lola.jpg",
									"model":"Lola"},
									{"quantities":{"M":8,"L":6,"XXS":1},
									"price":59.99,
									"image":"http://mylularoe.com/img/media/Ana.jpg",
									"model":"Ana"}]');
		$res = $mysqli->query($Q);
		while($txn = $res->fetch_assoc())
		{
			$txn['items'] = $stub_items;
			$txns[] = $txn;
		}	
		$mysqli->close();
		return(Response::json($txns, 200));
	}

	// Keep these separate for now
	public function refund($key = 0)
	{
		//does this session key correlate with the TID?

		$txdata = array(
			'transactionId'     => Input::get('transactionid'),
			'Subtotal'          => Input::get('subtotal'),
			'Tax'               => Input::get('tax'),
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

	public function purchase($key = 0, $cart = '')
	{
		$cartdata	= Input::get('cart', $cart);
		$endpoint	= '';

		if 		(Input::get('cash')) 	$txtype = 'CASH';
		elseif	(Input::get('check'))	$txtype = 'ACH';
		else 							$txtype = 'CARD';

		// Wish we could use sessions on all this, thanks IOS!
        $mbr = User::where('key', 'LIKE', $key.'|%')->first();


		// Set up appropraite transaction headers
		if ($txtype == 'CARD'){
			$txdata = array(
				'Subtotal'          => Input::get('subtotal'),
				'Tax'               => Input::get('tax'),
				'Account-name'      => Input::get('cardname'),
				'Card-Number'       => Input::get('cardnumber'),
				'Card-Code'     	=> Input::get('cardcvv'),
				'Card-Expiration'   => Input::get('cardexp'),
				'Card-Address'      => Input::get('cardaddress'),
				'Card-Zip'          => Input::get('cardzip'),
				'Description'       => json_encode($cartdata)
			);
			$endpoint = 'sale';
			foreach($txdata as $k=>$v) {
				$txheaders[] = "{$k}: {$v}";
			}
		}
		else if ($txtype == 'CASH') {
			$txdata = array(
				'Subtotal'          => Input::get('subtotal'),
				'Tax'               => Input::get('tax'),
				'Description'       => json_encode($cartdata)
			);
			$endpoint = 'cash';
			foreach($txdata as $k=>$v) {
				$cashparameters = array('Tax','Subtotal','Description');
				if (in_array($k, $cashparameters)) $txheaders[] = "{$k}: {$v}";
			}
		}
		else if ($txtype == 'CHECK') {
			$txdata = array(
				'Account-Name' 		=> Input::get('accountname'),
				'Routing-Number' 	=> Input::get('routing'),
				'Account-Number' 	=> Input::get('account'),
				'License-State' 	=> Input::get('dlstate'),
				'License-Number' 	=> Input::get('dlnum'),
				'Check-Number' 		=> Input::get('checknum'),
				'Subtotal'          => Input::get('subtotal'),
				'Tax'               => Input::get('tax'),
				'Description'       => json_encode($cartdata)
			);
			$endpoint = 'checkSale';
			foreach($txdata as $k=>$v) {
				if (in_array($k, $cashparameters)) $txheaders[] = "{$k}: {$v}";
			}
		}

		$purchase = self::makePayment($key, $txheaders, $endpoint);

		// Drop this into product table too.
		if (!$purchase['error']) {

			$lg = new Ledger();
			$lg->user_id		= $mbr->id;
			$lg->account		= '';
			$lg->amount			= Input::get('subtotal');
			$lg->tax			= Input::get('tax');
			$lg->txtype			= $txtype; 
			$lg->transactionid	= $purchase['id'];
			$lg->data			= json_encode($cartdata);
			$lg->save();

		}

        return Response::json($purchase, 200);
	}


	private function midcrypt($pass)
	{
		$penc = base64_encode(md5($pass,true));
		return($penc);
	}

	private function midauth($username = '', $password = '')
	{
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set to general auth for pulling inventory
		if (empty($username) && empty($password))
		{
			$username = urlencode(Config::get('site.mwl_username'));
			$password = urlencode(Config::get('site.mwl_password'));
		}
		else $password = Self::midcrypt($password);

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/'.Config::get('site.mwl_db')."/login/?username={$username}&password={$password}";
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		/* If we ever decide to 'POST'
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username={$username}&password={$password}");
		*/

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		if ($errno = curl_errno($ch)) {
			die('Something went wrong connecting to inventory system: '.$errno);
			return(false);
		}
		curl_close ($ch);

		if (!$server_output) return(false);
		else {
			$so = json_decode($server_output);
			if (isset($so->Code) && $so->Code == '401') return null;
			return($server_output);
		}
		
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

	private function makePayment($key, $txdata = array(), $type='sale') {
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

		if (!isset($response_obj->TransactionResponse)) {
			$response_obj = new stdClass();
			$response_obj = $raw_response;
			$response_obj->TransactionResponse = new stdClass();
			$response_obj->TransactionResponse->Error = true;
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

        return ($returndata);
	}

	public function auth($id, $pass = '') {
		$pass	= trim(Input::get('pass', $pass));
        $status = 'ERR';
        $error  = true;
		$data   = [];

		// Initialize these two
		$tstamp		= 0;
		$sessionkey = '';

		 // Find them here
        $mbr = User::where('id', '=', $id)->where('disabled', '=', '0')->get(array('id', 'email', 'key', 'password', 'first_name', 'last_name', 'image','public_id'))->first();

        // Can't find them?
        if (!isset($mbr)) {
            $mbr	= null;
            $status = 'User '.strip_tags($id).' not found';
        }
		else if (Hash::check($pass, $mbr['attributes']['password'])) {
        	$error  = false;
			$status = 'User '.strip_tags($id).' found ok';
			$data = array(
				'id'			=> $mbr['attributes']['id'],
				'public_id'		=> $mbr['attributes']['public_id'],
				'first_name'	=> $mbr['attributes']['first_name'],
				'last_name'		=> $mbr['attributes']['last_name'],
				'image'			=> $mbr['attributes']['image'],
				'key'			=> $mbr['attributes']['key'],
				'email'			=> $mbr['attributes']['email']
			);


			@list($sessionkey, $tstamp) = explode('|',$mbr['attributes']['key']);

			// 3 minutes timeout for session key - put this in a Config::get('site.mwl_session_timeout')!
			if (empty($sessionkey) || $tstamp < (time() - 10))
			{
				// Return the user is able to log in, but shut out of MWL

				// If we use the 'key' parameter, we could feasibly have 
				// Multiple acconts using 1 TID .. Feature?
				$sessionkey = Self::midauth($data['id'], $pass);
				$tstamp		= time();

				if ($this->logdata) file_put_contents('/tmp/logData.txt','TSTP: '.$tstamp." ".$sessionkey."\n",FILE_APPEND);
				if (!$sessionkey)
				{
					$status .= '; cannot retrieve key from payment system';
					$data['key'] = null;

					$mbr->update(array('key'=>''));
					// Also perform a logging notify here in papertrail or syslog?
				}
				else {
					$mbr->update(array('key'=>$sessionkey.'|'.time()));
				}
			}

		}
		else
		{
			$status = 'Cannot authorize';
			$mbr->update(array('key'=>''));
		}

		// Set session key to null 
		if (empty($sessionkey)) $sessionkey = null;
		
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data,'mwl'=>$sessionkey),200);

	}
   
    public function reorder(){
        $data = Input::all();
        if(empty($data)){
            $message = "No data posted";
            $status = "fail";    
        }else{
			Session::put('orderdata',$data);
            $message = "Successfully posted data";
            $status = "success"; 
        }
        return Response::json(['message'=>$message,'status'=>$status,'data'=>$data]);
    }

}
