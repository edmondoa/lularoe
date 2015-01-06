		<div class="breadcrumbs">
			@if (URL::previous() !== Request::url())
				<a href="{{ URL::previous() }}">
				&lsaquo; Back</a>
			@endif
		</div>