<?php

class TimezoneController extends \BaseController {

	public function setTimezone()
	{
		$data = Input::all();
		echo 'Successfully made it to the TimezoneController with data: ' . $data['timezone'] . '<br>';
		if (isset($data['timezone'])) {
			Session::put('timezone', $data['timezone']);
			return 'Succesfully added the timezone ' . Session::get('timezone') . ' to session timezone variable.';
		}
	}


}
