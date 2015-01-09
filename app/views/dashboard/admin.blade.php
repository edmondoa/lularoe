@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<h1>Dashboard</h1>
		@if ($beta_service_link->value == 1)
			<div class="alert alert-success inline-block">
				<a href="https://my.llr.controlpad.com/?uid={{ Auth::user()->id }}"><i class="fa fa-shopping-cart"></i> Click here to sign up for beta service</a>
			</div>
			<br>
		@endif
		<div class="alert alert-success inline-block">
			Copy and paste the following link and send it to anyone whom you'd like to join your team:<br>
			<a href="{{ url() }}/join/{{ $user->public_id }}">{{ url() }}/join/{{ $user->public_id }}</a>
		</div>
	</div>
	<div class="col col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Company Statistics</h2>
			</div>
			<table class="table table-striped">
				<tr>
					<th>Total ISM's</th>
					<td><a href="/downline/all/0">{{ $reps }}</a></td>
				</tr>
				<tr>
					<th>Top Level ISM's</th>
					<td><a href="/downline/immediate/{{ $user->id }}">{{ $user->front_line_count }}</a></td>
				</tr>
			</table>
		</div><!-- panel -->
	</div><!-- col -->
	<div class="col col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Quick Links</h2>
			</div>
			<div class="list-group">
				<a class="link list-group-item" href="{{ url() }}/join/{{ $user->public_id }}">My sign up form</a></li>
				<a class="link list-group-item" href='//{{ Auth::user()->public_id }}.{{ Config::get("site.base_domain") }}'>My site</a></li>
				<a class="link list-group-item" target='_blank' href='https://rightsignature.com/forms/W-9-2c6211/token/3733c94a942'>W9 form</a></li>
			</div>
		</div><!-- panel -->
	</div><!-- col -->
</div><!-- row -->
@stop
