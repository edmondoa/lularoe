<?php

class externalAuthController extends \BaseController {

	public function getInventory2()
	{
		// STUB
		return(file_get_contents('SampleInventory.json'));
	}

	public function getInventory($key, $location='Main')
	{
		// Cache this too .. 

		// Pull this out into an actual class for MWL php api
		$location = str_replace(' ','%20', $location);
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/llr/'.htmlentities($location,ENT_QUOTES,'UTF-8').'/inventorylist?sessionkey='.$key;
		curl_setopt($ch, CURLOPT_URL, $curlstring);

		/* If we ever decide to 'POST'
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username={$username}&password={$password}");
		*/

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
/*
    {
        "quantities": {
            "M": 1,
            "S": 1,
            "L": 1
        },
        "img_name": "CASSIE_525",
        "name": "Cassie"
    },
*/

			$itemnumber = $item['Item']['Part']['Number'];
			$quantity	= $item['Item']['Quantity']['OnHand'];

			ltrim(rtrim($itemnumber));

			// Delimiting sizes with hyphen and spaces
			if (strpos($itemnumber,' -') === false) 
			{
				$model = $itemnumber;
				$size  = 'NA';	
			}
			else list($model, $size) = explode(' -',$itemnumber);

			if ($lastmodel != $model) {
				$count++;
				$lastmodel = $model;
			}

			// Initialize this set of item data
			if (!isset($items[$count]))
			{
				$items[$count] = array(
				'UPC'			=>$item['Item']['UPC'],
				'SKU'			=>$item['Item']['Sku'],
				'price'			=>$item['Item']['Price'],
				
				'quantities'	=> array(), //array('NA'=>0,'XXS'=>0,'2XS'=>0,'XS'=>0,'S'=>0,'M'=>0,'L'=>0,'XL'=>0,'2XL'=>0,'3XL'=>0),
				'itemnumber'	=>$itemnumber,
				'model'			=>$model);
			}

			// Cut useless spaces
			$size = str_replace(' ','',$size);

			// Set up the quantities of each size
			if (!isset($items[$count]['quantities'][$size])) 
			{
				$items[$count]['quantities'][$size] = $quantity;
			}			

		}
		if (!isset($items)) $items = [];

		print json_encode($items, JSON_PRETTY_PRINT);
die();
		return(Response::json($items));
		// STUB
//		return(file_get_contents('SampleInventory.json'));
	}

	public function purchase($cart = array())
	{
		// STUB
		$subtotal 	= 199.99;
		$tax		= $subtotal * .08;
		$total 		= $subtotal + $tax;

		$purchase = array(	'errors'	=> false,
							'subtotal'	=> $subtotal,
							'tax'		=> $tax,
							'total'		=> $total);

		return(Response::json($purchase));
	}


	private function midcrypt($pass)
	{
		$penc = base64_encode(md5($pass,true));
		
		return($penc);
	}

	private function midauth($tid, $username, $password)
	{
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		$username = urlencode(Config::get('site.mwl_username'));
		$password = urlencode(Config::get('site.mwl_password'));
		// $password = urlencode(Self::midcrypt($password));

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
		else return($server_output);
		
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
				'tid'			=> '2', 	//STUB $mbr[0]['attributes']['key'],
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
			if (empty($sessionkey) || $tstamp < (time() - 10))
			{
				// Return the user is able to log in, but shut out of MWL
				$sessionkey = Self::midauth($data['tid'],$data['email'], $pass);

				// if we don't get a sessionkey back - something is wrong
				if (!$sessionkey)
				{
					$status .= '; cannot retrieve key from payment system';
					$data['tid'] = null;

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
		}
		
        //return Response::json(array('error'=>$error,'status'=>$status,'data'=>$mbr[0]['attributes']),200);
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data,'mwl'=>Session::get('mwl_id')),200);

	}

}

