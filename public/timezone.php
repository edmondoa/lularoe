<?
	$data = Input::all();
	if (isset($data['timezone'])) {
		Session::put('timezone', $data['timezone']);
	}
?>