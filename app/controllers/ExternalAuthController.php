<?php

class externalAuthController extends \BaseController {

	public function getInventory2()
	{
		// STUB
		return(file_get_contents('SampleInventory.json'));
	}

	public function getInventory($key)
	{
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/fishbowl/locationgroups?sessionkey='.$key;
		echo $curlstring;
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

		return('<h1>Coming from mwl</h1> '.$server_output);
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

		$username = urlencode($username);
		$password = Self::midcrypt($password);

		// Set this to HTTPS TLS / SSL
		$curlstring = Config::get('site.mwl_api').'/login/'.Config::get('site.mwl_db')."/?username={$username}&password={$password}";
		// echo $curlstring;
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
				list($tstamp, $sessionkey)		= explode('|',Session::get('mwl_id'));
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
					Session::put('mwl_id', time().'|'.$sessionkey);
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

