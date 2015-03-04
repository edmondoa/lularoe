@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>My Settings</h1>
	</div>
	<div class="col col-lg-4 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">User Settings</h2>
			</div>
			<div class="list-group">
				<a class="link list-group-item" href="/users/{{ Auth::user()->id }}/edit"><span class="fa fa-user"></span> Edit Profile</a>
				<a class="link list-group-item" href="/users/{{ Auth::user()->id }}/privacy"><span class="fa fa-lock"></span> Privacy &amp; Communication Preferences</a>
			</div>
		</div>
	</div>
	<div class="col col-lg-4 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Bank Information</h2>
			</div>
			<div class="list-group">
				@foreach ($bankinfo as $bank)
					<li class="list-group-item">
						<a href="/bankinfo/{{ $bank->id }}/edit">
							<span class="fa fa-home"></span> Edit &quot;{{ $bank->bank_name }}&quot; ending in <?=substr($bank->bank_account,-5)?>
						</a>
					</li>
				@endforeach
			</div>
			<div class="panel-footer">
				<a class="btn btn-primary" href="/bankinfo/create"><i class="fa fa-plus"></i> Add Account</a>
			</div>
		</div>
	</div>
	<div class="col col-lg-4 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Addresses</h2>
			</div>
			<div class="list-group">
				@foreach ($addresses as $address)
					<li class="list-group-item">
						<a href="/addresses/{{ $address->id }}/edit">
							<span class="fa fa-home"></span> Edit {{ $address->label }} Address
						</a>
						<a class="pull-right" href="/addresses/{{ $address->id }}/delete"><i class="fa fa-trash"></i></a>
					</li>
				@endforeach
			</div>
			<div class="panel-footer">
				<a class="btn btn-primary" href="/addresses/create"><i class="fa fa-plus"></i> Add Address</a>
			</div>
		</div>
	</div>
</div>
@stop
