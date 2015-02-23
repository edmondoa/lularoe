		<div class="breadcrumbs">
			@if (Session::get('previous_page') != Request::url())
				<a href="{{ Session::get('previous_page') }}">
				&lsaquo; Back</a>
			@endif
		</div>