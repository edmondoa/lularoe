		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" id="logo" href="//{{ Config::get('site.domain') }}"><img style="position:relative; bottom:-5px;" src="{{ Config::get('site.company_logo_minimal') }}" width="100" alt="{{ Config::get('site.company_name') }}"></a>
		</div>
		<div class="collapse navbar-collapse">
			@if (!Auth::check())
				<ul class="nav navbar-nav navbar-right">
					<li><a href="//{{ Config::get('site.domain') }}/login">Log In</a></li>
				</ul>
			@else
	            <ul class="nav navbar-nav navbar-right" id="top-right-menu">
	            	@if ($layout == 'default')
	                    <?php
	                    	if (Auth::check()) {
								if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
		                    		$pages = Page::where('Reps', 1)->orWhere('Customers', 1)->orWhere('Public', 1)->where('back_office_header', 1)->get();
								}
								elseif (Auth::user()->hasRole(['Customer'])) {
		                    		$pages = Page::where('Customers', 1)->orWhere('Public', 1)->where('back_office_header', 1)->get();
								}
								elseif (Auth::user()->hasRole(['Rep'])) {
		                    		$pages = Page::where('Reps', 1)->orWhere('Public', 1)->where('back_office_header', 1)->get();
								}
							}
							else $pages = Page::where('back_office_header', 1)->where('Public', 1)->get();
	                    ?>
	                @elseif ($layout == 'gray')
	                    <?php
	                    	if (Auth::check()) {
								if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
		                    		$pages = Page::where('Reps', 1)->orWhere('Customers', 1)->orWhere('Public', 1)->where('public_header', 1)->get();
								}
								elseif (Auth::user()->hasRole(['Customer'])) {
		                    		$pages = Page::where('Customers', 1)->orWhere('Public', 1)->where('public_header', 1)->get();
								}
								elseif (Auth::user()->hasRole(['Rep'])) {
		                    		$pages = Page::where('Reps', 1)->orWhere('Public', 1)->where('public_header', 1)->get();
								}
							}
							else $pages = Page::where('public_header', 1)->where('Public', 1)->get();
	                    ?>
	                @endif
	                @if (isset($pages))
						@foreach ($pages as $page)
							<li><a href="//{{ Config::get('site.domain') }}/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
						@endforeach
					@endif
					@if (Auth::user()->hasSignUp)
	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        <i class="fa fa-user"></i> {{ Auth::user()->first_name }}
	                        <b class="caret"></b>
	                    </a>
	                    <ul class="dropdown-menu">
	                        <li><a href="//{{ Config::get('site.domain') }}/dashboard"><span class="fa fa-dashboard"></span> &nbsp;Dashboard</a></li>
	                        <li><a href="//{{ Config::get('site.domain') }}/settings"><span class="fa fa-cog"></span> &nbsp;My Settings</a></li>
	                        <li><a href="//{{ Config::get('site.domain') }}/logout"><span class="fa fa-sign-out"></span> &nbsp;Log Out</a></li>
	                    </ul>
	                </li>
					@endif
	            </ul>
			@endif
		</div><!-- /.nav-collapse -->
