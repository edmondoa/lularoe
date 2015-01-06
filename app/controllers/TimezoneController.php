<?php

class TimezoneController extends \BaseController {

	public function setTimezone()
	{
		$data = Input::all();
		if (isset($data['timezone'])) {
			Session::put('timezone', $data['timezone']);
		}
	}


}
