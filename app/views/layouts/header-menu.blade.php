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
			@if (!Auth::check())
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/login">Log In</a></li>
				</ul>
			@else
	            <ul class="nav navbar-nav navbar-right">
	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        {{ Auth::user()->first_name }}
	                        <b class="caret"></b>&nbsp;&nbsp;&nbsp;
	                    </a>
	                    <ul class="dropdown-menu">
	                        <li><a href="/settings"><span class="fa fa-cog"></span> &nbsp;Settings</a></li>
	                        <li><a href="{{ route('logout')}}"><span class="fa fa-sign-out"></span> &nbsp;Log Out</a></li>
	                    </ul>
	                </li>
	            </ul>
			@endif
		</div><!-- /.nav-collapse -->