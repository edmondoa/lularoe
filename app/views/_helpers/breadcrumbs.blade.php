		<div class="breadcrumbs">
			@if (Session::get('previous_page') != Request::url())
				<a href="{{ Session::get('previous_page') }}">
			@else
				<a href="{{ Session::get('previous_page_2') }}">
			@endif
			&lsaquo; Back</a>
		</div>