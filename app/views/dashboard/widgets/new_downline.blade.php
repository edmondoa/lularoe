		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">New Downline<!-- <span class="badge">{{ $new_downline_count_30 }}</span>--></h2>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Sign up Time</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($new_downline as $user)
						<tr>
							<td>{{ date('M d, H:i a', strtotime($user->created_at)) }}</td>
							<td><a href="/users/{{ $user->id }}">{{ $user->full_name }}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@if ($new_downline_count_30 > 10)
				<div class="panel-footer overflow-hidden">
					<div class="pull-right">
						<a href="/downline/new/{{ Auth::user()->id }}" class="btn btn-primary" class="btn btn-primary">View All <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			@else
				<div class="panel-body">
					<small>(No new downline)</small>
				</div>
			@endif
		</div><!-- panel -->