<?php $layout = 'gray' ?>
@include('layouts.header')
<div id="header-menu" class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
		@include('layouts.header-menu')
	</div><!-- container -->
</div><!-- /.navbar -->
@section('banner')
@show
<div id="container" class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-md-12" id="main">
			<div class="row">
				<div class="col col-md-12">
					@include('_helpers.errors')
					@include('_helpers.message')
				</div>
			</div>
			@section('content')
			@show
 		</div><!--/col-->
 	</div><!--/row-->
</div><!--/container-->
<footer>
    <?php
    	if (Auth::check()) {
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
        		$pages = Page::where('Reps', 1)->orWhere('Customers', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
			}
			elseif (Auth::user()->hasRole(['Customer'])) {
        		$pages = Page::where('Customers', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
			}
			elseif (Auth::user()->hasRole(['Rep'])) {
        		$pages = Page::where('Reps', 1)->orWhere('Public', 1)->where('public_footer', 1)->get();
			}
		}
		else $pages = Page::where('public_footer', 1)->where('Public', 1)->get();
    ?>
    @if (isset($pages))
        <ul class="footer-menu">
			@foreach ($pages as $page)
				<li><a href="/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
			@endforeach
		</ul>
	@endif
	<p>&copy; {{ Config::get('site.company_name') }} 2014</p>
</footer>
@include('layouts.footer')
