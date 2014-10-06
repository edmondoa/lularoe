	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@elseif(!empty($message))
		<div class="alert alert-success">{{ $message }}</div>
	@endif
