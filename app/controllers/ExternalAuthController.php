<?php

class externalAuthController extends \BaseController {

	public function getInventory()
	{
		// STUB
		return(file_get_contents('SampleInventory.json'));
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

		return(json_encode($purchase));
	}


	private function midcrypt($cid, $pass)
	{
		$penc = base64_encode(md5($pass,true));
		$penc = base64_encode(md5('admin',true));
		
		return($penc);
	}

	private function midauth($tid, $username, $password)
	{
		// Pull this out into an actual class for MWL php api
		$ch = curl_init();

		$username = urlencode($username);
		$password = Self::midcrypt('llr', $password);

		// Set this to HTTPS TLS / SSL
		curl_setopt($ch, CURLOPT_URL, Config::get('site.mwl_api').'/login/'.Config::get('site.mwl_db')."/?username={$username}&password={$password}");
		// echo Config::get('site.mwl_api').'/login/'.Config::get('site.mwl_db')."/?username={$username}&password={$password}";

		/* 
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
			// Also check here if they exist in FISHBOWL!
			
        }
		else if (Hash::check($pass, $mbr[0]['attributes']['password'])) {
        	$error  = false;
			$status = 'User '.strip_tags($id).' found ok';
			$data = array(
				'id'			=> $mbr[0]['attributes']['id'],
				'first_name'	=> $mbr[0]['attributes']['first_name'],
				'last_name'		=> $mbr[0]['attributes']['last_name'],
				'image'			=> $mbr[0]['attributes']['image'],
				'tid'			=> '1', 	//STUB $mbr[0]['attributes']['key'],
				'email'			=> 'admin',  //STUB $mbr[0]['attributes']['email']
				'session'		=> Session::getId()
			);

			// Return the user is able to log in, but shut out of MWL
			$sessionkey = Self::midauth($data['tid'],$data['email'], Self::midcrypt('llr', $pass));

			// if we don't get a sessionkey back - something is wrong
			if (!$sessionkey)
			{
				$status .= '; cannot retrieve key from payment system';
				$data['tid'] = null;

				// Also perform a logging notify here in papertrail or syslog?
			}
			else {
				Session::put('mwl_id', $sessionkey);
			}
		}
		else
		{
			$status = 'Cannot authorize';
		}
		
        //return Response::json(array('error'=>$error,'status'=>$status,'data'=>$mbr[0]['attributes']),200);
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data),200);

	}

}

