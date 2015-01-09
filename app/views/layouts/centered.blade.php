<?php $layout = 'centered' ?>
@include('layouts.header')
<div id="header-menu" class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
		@include('layouts.header-menu')
	</div><!-- container -->
</div><!-- /.navbar -->
<div class="container">
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
	<hr>
	<footer>
		<p>&copy; {{ Config::get('site.company_name')}} 2014</p>
 	</footer>
</div><!--/container-->
@include('layouts.footer')