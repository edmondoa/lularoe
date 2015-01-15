<?php

class TimezoneController extends \BaseController {

	public function setTimezone()
	{
		return 'Successfully made it to the TimezoneController with data: ' . $data['timezone'];
		$data = Input::all();
		if (isset($data['timezone'])) {
			Session::put('timezone', $data['timezone']);
			return 'Succesfully added the timezone ' . Session::get('timezone') . ' to session timezone variable.';
		}
	}


}
