<?php

class TimezoneController extends \BaseController {

	public function set()
	{
		$data = Input::all();
		if ($data['timezone'] == 'America/Denver') $data['timezone'] = 'US/Mountain';
		Session::put('timezone', $data['timezone']);
	}


}
