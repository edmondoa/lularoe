@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<h1>Dashboard</h1>
		<div class="alert alert-success inline-block">
			Copy and paste the following link and send it to anyone whom you'd like to join your team:<br>
			<a href="{{ url() }}/join/{{ $user->public_id }}">{{ url() }}/join/{{ $user->public_id }}</a>
		</div>
	</div>
	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Company Statistics</h2>
			</div>
			<table class="table table-striped">
				<tr>
					<th>Total FC's</th>
					<td><a href="/downline/all/{{ Config::get('site.admin_uid') }}">{{ $reps }}</a></td>
				</tr>
				<tr>
					<th>Top Level FC's</th>
					<td><a href="/downline/immediate/{{ $user->id }}">{{ $user->front_line_count }}</a></td>
				</tr>
			</table>
		</div><!-- panel -->
	</div><!-- col -->
</div><!-- row -->
@stop
