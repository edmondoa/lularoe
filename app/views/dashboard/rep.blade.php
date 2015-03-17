@extends('layouts.default')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1 class="pull-left">Welcome, {{ $user->first_name }}</h1>
			<a class="btn btn-primary pull-right margin-bottom-2" href="/sales/create"><i class='fa fa-plus'></i> New Sale</a>
			<div class="clear"></div>
			<p class="well inline-block">
				Send the following link to anyone whom you'd like to join your team:<br>
				<a href="{{ url() }}/join/{{ $user->public_id }}">{{ url() }}/join/{{ $user->public_id }}</a>
			</p>
		</div>
	</div><!-- row -->
	<div class="row masonry">
		@if (count($recent_post) > 0)
			<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
				@include('dashboard.widgets.recent_post')
			</div><!-- col -->
		@endif
		<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
			@include('dashboard.widgets.new_downline')
		</div><!-- col -->
		<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading" style="background:#9595D2 !important;">
					<h2 class="panel-title">Overview</h2>
				</div>
				<table class="table table-striped">
					@if ($user->consignment > 0)
					<tr>
						<th>Your remaining consignment balance:</th>
						<td>{{ $user->consignment }}</td>
					</tr>
					@endif
					<tr>
						<th>Your Leadership Level:</th>
						<td>{{ $user->rank_name }} (Rank {{ $user->rank_id }})</td>
					</tr>
					<tr>
						<th>Your Public ID:</th>
						<td>{{ $user->public_id }}</td>
					</tr>
					<tr>
						<th>Your Consultant ID:</th>
						<td>{{ $user->id }}</td>
					</tr>
					<tr>
						<th>Sponsored Members</th>
						<td><a href="/downline/immediate/{{ $user->id }}">{{ $user->front_line_count }}</a></td>
					</tr>
					<tr>
						<th>Members in Entire Team</th>
						<td><a href="/downline/all/{{ $user->id }}">{{ $user->descendant_count }}</a></td>
					</tr>
					@if (isset($sponsor))
						<tr>
							<th>Your Sponsor:</th>
							<td><a href="users/{{ $sponsor->id }}">{{ $sponsor->first_name }} {{ $sponsor->last_name }}</a></td>
						</tr>
					@endif
				</table>
			</div><!-- panel -->
		</div><!-- col -->
		@if (count($ranks) > 1)
			<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Rank Advancement History</h2>
						</div>
						<table class="table table-striped">
							<thead>
								<th>Date</th>
								<th>Rank</th>
							</thead>
							<tbody>
								@foreach ($ranks as $rank)
									<tr>
										<td>{{ date('M d Y', strtotime($rank->pivot->created_at)) }}</td>
										<td>{{ $rank->name }} (Rank {{ $rank->id }})</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div><!-- panel -->
			</div><!-- col -->
		@endif
		<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading" style="background:#DD7FD3 !important;">
					<h2 class="panel-title">Quick Links</h2>
				</div>
				<div class="list-group">
					<a class="link list-group-item" href="{{ url() }}/join/{{ $user->public_id }}">Join My Team</a>
					<a class="link list-group-item" href='//{{ Auth::user()->public_id }}.{{ Config::get("site.base_domain") }}'>My site</a>
					<!-- <a class="link list-group-item" target='_blank' href='https://rightsignature.com/forms/2014w9-4555d8/token/12e754b6c0b'>W9 form</a> -->
				</div>
			</div><!-- panel -->
		</div><!-- col -->
	</div><!-- row -->
@stop
