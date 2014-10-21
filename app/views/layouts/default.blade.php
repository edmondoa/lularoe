<?php $layout = 'default' ?>
@include('layouts.header')
<div id="header-menu" class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	@include('layouts.header-menu')
</div><!-- /.navbar -->
<div class="row row-offcanvas row-offcanvas-right">
	<div class="col-xs-6 col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
		@include('layouts.main-menu')
	</div><!--/col-->
	<div class="col-xs-12 col-sm-9 col-md-10" id="main">
		<div class="row">
			<div class="col col-md-12">
				@include('_helpers.errors')
				@include('_helpers.message')
			</div>
		</div>
		@section('content')
		@show
		<hr>
		<footer>
			<p>&copy; SociallyMobile {{ date('Y') }}</p>
		</footer>
	</div><!--/col-->
</div><!--/row-->
@include('layouts.footer')