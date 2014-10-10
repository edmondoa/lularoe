@extends('layouts.default')
@section('content')
<div class="row">
	<div style="margin-left:15px;">
		<h1>Welcome, {{ $user->first_name }}</h1>
		<p>Copy and paste the following link and send it to anyone whom you'd like to join your team:</p>
		<pre class="inline-block"><a href="{{ url() }}/join/{{ $user->public_id }}">{{ url() }}/join/{{ $user->public_id }}</a></strong></pre>
	</div>
	<div class="col col-md-6">
		@if (isset($sponsor))
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
							<td><a href="users/{{ $sponsor->id }}">{{ $sponsor->first_name }} {{ $sponsor->last_name }}</a></td>
							<td>{{ $sponsor->phone }}</td>
							<td>{{ $sponsor->email }}</td>
						</tr>
					</tbody>
				</table>
			</div><!-- panel -->
		@endif
		@if (isset($children))
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
		@endif
	</div><!-- col -->

</div>
@stop
