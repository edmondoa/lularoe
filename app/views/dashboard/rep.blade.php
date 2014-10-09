@extends('layouts.default')
@section('content')
<div class="row">
	<div style="margin-left:15px;">
		<h1>Welcome, {{ $user->first_name }}</h1>
		<div class="alert alert-success">
			<p>Your sponsor ID is <strong>{{ $user->id }}</strong>. Share this with anyone whom you would like to join your team.</p>
		</div>
	</div>
	<div class="col col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Your Info</h2>
			</div>
			<table class="table table-striped">
				<tr>
					<th>Mobile Plan:</th>
					<td>{{ $user->mobile_plan }}</td>
				</tr>
				<tr>
					<th>Your Rank:</th>
					<td>ISM</td>
				</tr>
			</table>
		</div><!-- panel -->
	</div><!-- col -->
	<div class="col col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Your Sponsor</h2>
			</div>
			<table class="table table-striped">
				<thead>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
				</thead>
				<tbody>
					<tr>
						<td>{{ $sponsor->first_name }} {{ $sponsor->last_name }}</td>
						<td>{{ $sponsor->phone }}</td>
						<td>{{ $sponsor->email }}</td>
					</tr>
				</tbody>
			</table>
		</div><!-- panel -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Your Team</h2>
			</div>
			<table class="table table-striped">
				<thead>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
				</thead>
				<tbody>
					@foreach ($children as $child)
					<tr>
						<td><a href="users/{{ $child->id }}">{{ $child->first_name }} {{ $child->last_name }}</a></td>
						<td>{{ $child->phone }}</td>
						<td>{{ $child->email }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div><!-- panel -->
	</div><!-- col -->

</div>
@stop
