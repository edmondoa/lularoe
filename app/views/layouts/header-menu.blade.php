		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" id="logo" href="http://sociallymobile.com"><img src="/img/socially-mobile-logo.png" width="175" alt="Socially Mobile"></a>
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