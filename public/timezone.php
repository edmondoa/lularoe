<?
	// session_start();
	$data = Input::all();
	if (isset($data['timezone'])) {
		Session::put('timezone', $_REQUEST['timezone']);
	}
?>