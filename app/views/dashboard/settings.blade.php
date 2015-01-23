@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-lg-4 col-md-6">
		<h1>My Settings</h1>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">User Settings</h2>
			</div>
			<div class="list-group">
				<a class="link list-group-item" href="/users/{{ Auth::user()->id }}/edit"><span class="fa fa-user"></span> Edit Profile</a>
				@foreach ($addresses as $address)
					<a class="link list-group-item" href="/addresses/{{ $address->id }}/edit"><span class="fa fa-home"></span> Edit {{ $address->label }} Address</a>
				@endforeach
				<a class="link list-group-item" href="/users/{{ Auth::user()->id }}/privacy"><span class="fa fa-lock"></span> Privacy &amp; Communication Preferences</a>
			</div>
		</div>
	</div>
</div>
@stop
