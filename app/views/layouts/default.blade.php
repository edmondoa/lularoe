<!DOCTYPE html>
<html ng-app="ui.bootstrap.demo">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SociallyMobile</title>
		<link href="{{ url('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<style>
		body {
		padding-top: 60px;
		}
	</style>
	<link href="{{ url('bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	{{ HTML::style('css/theme.css') }}
	{{ HTML::style('packages/bootstrap-select/bootstrap-select.min.css') }}
	{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
</head>
<body>
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" id="logo" href="#"><img src="/img/socially-mobile-logo.png" alt="Socially Mobile"></a>
	</div>
	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			@if (!Auth::check())
				<li><a href="/login">Log In</a></li>
			@else
				<li><a href="/dashboard">Dashboard</a></li>
				<li><a href="/logout">Log Out</a></li>
			@endif
			<!-- <li class="active"><a href="#">Home</a></li>
			<li><a href="#about">About</a></li>
			<li><a href="#contact">Contact</a></li> -->
		</ul>
	</div><!-- /.nav-collapse -->
	</div><!-- container -->
</div><!-- /.navbar -->
<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		
 		@if (Auth::check() && (Auth::user()->hasRole(['Admin','Superadmin'])))
 		<div class="col-xs-6 col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
			<div class="list-group">
				<!-- <a href="{{ url('addresses') }}" class="list-group-item">Addresses</a> -->
				<!-- <a href="{{ url('bonuses') }}" class="list-group-item">Bonuses</a> -->
				<!-- <a href="{{ url('cart') }}" class="list-group-item">Cart</a> -->
				<!-- <a href="{{ url('commissions') }}" class="list-group-item">Commissions</a> -->
				<!-- <a href="{{ url('emailMessages') }}" class="list-group-item">EmailMessages</a> -->
				<!-- <a href="{{ url('images') }}" class="list-group-item">Images</a> -->
				<!-- <a href="{{ url('levels') }}" class="list-group-item">Levels</a> -->
				<!-- <a href="{{ url('pages') }}" class="list-group-item">Pages</a> -->
				<!-- <a href="{{ url('payments') }}" class="list-group-item">Payments</a> -->
				<!-- <a href="{{ url('products') }}" class="list-group-item">Products</a> -->
				<!-- <a href="{{ url('profiles') }}" class="list-group-item">Profiles</a> -->
				<!-- <a href="{{ url('ranks') }}" class="list-group-item">Ranks</a> -->
				<!-- <a href="{{ url('reviews') }}" class="list-group-item">Reviews</a> -->
				<!-- <a href="{{ url('roles') }}" class="list-group-item">Roles</a> -->
				<!-- <a href="{{ url('sales') }}" class="list-group-item">Sales</a> -->
				<a href="{{ url('users') }}" class="list-group-item">Users</a>
				<!-- <a href="{{ url('userProducts') }}" class="list-group-item">UserProducts</a> -->
				<!-- <a href="{{ url('userRanks') }}" class="list-group-item">UserRanks</a> -->
				<!-- <a href="{{ url('smsMessages') }}" class="list-group-item">SmsMessages</a> -->
 			</div>
		</div><!--/span-->
	 	@endif
		<div class="col-xs-12 col-sm-9 col-md-10">
			<div class="row">
				@include('_helpers.errors')
				@include('_helpers.message')
			</div>
			@section('content')
			@show
 		</div><!--/span-->
	</div><!--/row-->
	<hr>
	<footer>
		<p>&copy; SociallyMobile 2014</p>
 	</footer>
</div>
{{ HTML::script('/js/jquery1.js') }}
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
{{ HTML::script('/packages/bootstrap-select/bootstrap-select.min.js') }}
{{ HTML::script('jquery-ui-1.10.4.custom.min.js') }}
{{ HTML::script('js/functions.js') }}
<script src="/js/controllers/datepickerController.js"></script>
<!--[javascript]-->
</body>
</html>
