<?php $layout = 'default' ?>
@include('layouts.header')
<div id="header-menu" class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	@include('layouts.header-menu')
</div><!-- /.navbar -->
<div id="main">
	<div id="sidebar" role="navigation">
		@include('layouts.main-menu')
	</div><!--/col-->
	<div id="content">
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