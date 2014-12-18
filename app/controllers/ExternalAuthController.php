<?php

class externalAuthController extends \BaseController {

	public function auth($id)
	{
		$pass	= trim(Input::get('pass'));
        $status = 'ERR';
        $error  = true;

		 // Find them here
        $mbr = User::where('id', '=', $id)->where('disabled', '=', '0')->get(array('id', 'password', 'first_name', 'last_name', 'image'));
		
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
				'image'			=> $mbr[0]['attributes']['image']
			);
		}
		
        //return Response::json(array('error'=>$error,'status'=>$status,'data'=>$mbr[0]['attributes']),200);
        return Response::json(array('error'=>$error,'status'=>$status,'data'=>$data),200);

	}

}
