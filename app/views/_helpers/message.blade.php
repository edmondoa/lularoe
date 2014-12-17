	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@elseif (Session::has('message_caution'))
		<div class="alert alert-caution">{{ Session::get('message_caution') }}</div>
	@elseif (Session::has('message_danger'))
		<div class="alert alert-danger">{{ Session::get('message_danger') }}</div>
	@endif
