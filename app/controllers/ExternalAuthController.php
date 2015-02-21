<?php

class ExternalAuthController extends \BaseController {

	public function getInventory2()
	{
		// STUB
		return(file_get_contents('SampleInventory.json'));
	}

	public function getInventory($key = 0, $location='Main')
	{
		// Cache this too .. 

		// Get MAIN inventory as default
		if ($key == null)
		{
			// Return the user is able to log in, but shut out of MWL
			$key = Self::midauth(); // stub parameters
		}

		// Pull this out into an actual class for MWL php api
		$location = str_replace(' ','%20', $location);
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/llr/'.htmlentities($location,ENT_QUOTES,'UTF-8').'/inventorylist?sessionkey='.$key;
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		if ($errno = curl_errno($ch)) {
			print json_encode(array('errors'=>true,'message'=> 'Something went wrong connecting to inventory system.','errno'=>$errno));
			return(false);
		}
		curl_close ($ch);

		$output = json_decode($server_output, true); // true = array
		$model		= '';
		$lastmodel	= '';
		$count = 0;


		// Transform the output to the appropriate IOS format
		foreach($output['Inventory'] as $item) 
		{

			$itemnumber = $item['Item']['Part']['Number'];
			$quantity	= $item['Item']['Quantity']['OnHand'];

			ltrim(rtrim($itemnumber));

			$model = preg_replace('/ -.*$/','',$item['Item']['Part']['Number']);
			$itemList[$model] = '';

			// Delimiting sizes with hyphen and spaces
			if (strpos($itemnumber,' -') === false) 
			{
		//		$model = $itemnumber;
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
				
				'quantities'	=> array()); //array('NA'=>0,'XXS'=>0,'2XS'=>0,'XS'=>0,'S'=>0,'M'=>0,'L'=>0,'XL'=>0,'2XL'=>0,'3XL'=>0),
				//'itemnumber'	=>$itemnumber,
			}

			// Cut useless spaces
			$size = str_replace(' ','',$size);

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
			$itemlist[$count++] = $v;
		}

		//print json_encode($itemlist, JSON_PRETTY_PRINT);
		return(Response::json($itemlist,200));
		// STUB
//		return(file_get_contents('SampleInventory.json'));
	}


	// What is this hackery?!
	// It is this way until we have proper api access to the ledger.
	public function ledger($ref = null)
	{
		try {
			$mysqli = new mysqli('mwl.controlpad.com', 'llr_txn', 'ilovetexas', 'llr');
		}
		catch (Exception $e)
		{
			$noconnect = array('error'=>true,'message'=>'Transaction database connection failure: '.$e->getMessage());
			return(Response::json($noconnect,200));
		}

		$Q = "SELECT tid, refNum, result, authAmount, salesTax,  cashsale, processed, refunded FROM transaction LEFT JOIN sessionkey ON(userid=tid) WHERE `key`='".Session::get('mwl_id')."'";
		if ($ref != null) $Q .= " AND refNum='".intval($ref)."' LIMIT 1";

		$txns = [];
		$res = $mysqli->query($Q);
		while($txn = $res->fetch_assoc())
		{
			$txns[] = $txn;
		}	
		return(Response::json($txns, 200));
	}

	public function purchase($tid, $cart = array())
	{
       $txdata = array(
                    'Tid'          		=> $tid,
                    'Subtotal'          => Input::get('subtotal'),
                    'Tax'               => Input::get('tax'),
                    'Account-name'      => Input::get('cardname'),
                    'Card-Number'       => Input::get('cardnumber'),
                    'Card-Code'     	=> Input::get('cardcvv'),
                    'Card-Expiration'   => Input::get('cardexp'),
                    'Card-Address'      => Input::get('cardaddress'),
                    'Card-Zip'          => Input::get('cardzip'),
/*
                    'transactionId'     => Input::get('txid'),
                    'pinHash'           => Input::get('pinHash'),
*/
                    );

		foreach($txdata as $k=>$v)
		{
			$txheaders[] = "{$k}: {$v}";
		}

        $purchase = self::makeSale($tid, $txheaders);

		return($purchase);
	}


	private function midcrypt($pass)
	{
		$penc = base64_encode(md5($pass,true));
		return($penc);
	}

	private function midauth($tid = '', $username = '', $password = '')
	{
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set to general auth for pulling inventory
		if (empty($tid) && empty($username) && empty($password))
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

	private function makeSale($tid = NULL, $txdata = array()) {
		// Whether or not to write to /tmp/request.txt for debuggification
		$verbose = false; 

		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/'.Config::get('site.mwl_db')."/payment/sale?sessionkey=".Session::get('mwl_id');
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
			unset($response_obj);
			$response_obj = new stdClass();
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

        return Response::json(array('error'=>$response_obj->TransactionResponse->Error,
									'result'=>$response_obj->TransactionResponse->Result, 
									'status'=>$response_obj->TransactionResponse->Status,
									'amount'=>$response_obj->TransactionResponse->AuthAmount,
									'data'=>$raw_response),200);
	}

	public function auth($id)
	{
		$pass	= trim(Input::get('pass'));
        $status = 'ERR';
        $error  = true;
		$data   = [];

		 // Find them here
        $mbr = User::where('id', '=', $id)->where('disabled', '=', '0')->get(array('id', 'email', 'key', 'password', 'first_name', 'last_name', 'image'));
		
		//$lastq = DB::getQueryLog();
		//print_r(end($lastq));

        // Can't find them?
        if (!isset($mbr[0])) {
            $mbr	= null;
            $status = 'User '.strip_tags($id).' not found';
        }
		else if (Hash::check($pass, $mbr[0]['attributes']['password'])) {
        	$error  = false;
			$status = 'User '.strip_tags($id).' found ok';
			$data = array(
				'id'			=> $mbr[0]['attributes']['id'],
				'first_name'	=> $mbr[0]['attributes']['first_name'],
				'last_name'		=> $mbr[0]['attributes']['last_name'],
				'image'			=> $mbr[0]['attributes']['image'],

				// If we use the 'key' parameter, we could feasibly have 
				// Multiple acconts using 1 TID .. Feature?
				'tid'			=> $mbr[0]['attributes']['key'],
				'email'			=> $mbr[0]['attributes']['email'],
				'session'		=> Session::getId()
			);

			// Initialize these two
			$tstamp		= 0;
			$sessionkey = '';

			// If we already have a sesionable mwl_id with timestamp ..
			if (Session::has('mwl_id'))
			{
				$sessionkey		= Session::get('mwl_id');
				$tstamp			= Session::get('mwl_stamp');
			}

			// 3 minutes timeout for session key - put this in a Config::get('site.mwl_session_timeout')!
			if (empty($sessionkey) || $tstamp < (time() - 360))
			{
				// Return the user is able to log in, but shut out of MWL
				$sessionkey = Self::midauth($data['tid'], $data['id'], $pass);

				// if we don't get a sessionkey back - something is wrong
				if (!$sessionkey)
				{
					$status .= '; cannot retrieve key from payment system';
					$data['tid'] = null;

					Session::forget('mwl_id');
					Session::forget('mwl_stamp');

					// Also perform a logging notify here in papertrail or syslog?
				}
				else {
					Session::put('mwl_id', $sessionkey);
					Session::put('mwl_stamp', time());
				}
			}
		}
		else
		{
			$status = 'Cannot authorize';
			Session::forget('mwl_id');
			Session::forget('mwl_stamp');
		}
		
        //return Response::json(array('error'=>$error,'status'=>$status,'data'=>$mbr[0]['attributes']),200);
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data,'mwl'=>Session::get('mwl_id')),200);

	}

}

