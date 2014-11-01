		<div class="breadcrumbs">
			@if (URL::previous() == url())
				<a href="/users">
			@else
				<a href="{{ URL::previous() }}">
			@endif
			&lsaquo; Back</a>
		</div>