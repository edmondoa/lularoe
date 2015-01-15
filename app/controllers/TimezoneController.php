<?php

class TimezoneController extends \BaseController {

	public function setTimezone()
	{
		$data = Input::all();
		if (isset($data['timezone'])) {
			Session::put('timezone', $data['timezone']);
			echo 'Succesfully added the timezone ' . Session::get('timezone') . ' to session timezone variable.';
		}
	}


}
