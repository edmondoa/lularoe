	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@elseif(!empty($message))
		<div class="alert alert-caution">{{ $message }}</div>
	@elseif(!empty($danger_message))
		<div class="alert alert-danger">{{ $danger_message }}</div>
	@endif
