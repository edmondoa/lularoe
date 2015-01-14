<!doctype html>
<html lang="en-US">
    <head>

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

        <!--Shortcut icon-->

        <title><?php if (isset($title)) echo $title . ' | ' ?>SociallyMobile</title>

        <link rel="alternate" type="application/rss+xml" title="SociallyMobile &raquo; Feed" href="/feed/" />
        <link rel="alternate" type="application/rss+xml" title="SociallyMobile &raquo; Comments Feed" href="/comments/feed/" />
        <meta property='og:site_name' content='SociallyMobile'/>
        <meta property='og:url' content='/privacy-policy/'/>
        <meta property='og:title' content='Privacy Policy'/>
        <meta property='og:type' content='article'/>
        <link rel='stylesheet' id='js_composer_front-css'  href='/wp-content/themes/salient/wpbakery/js_composer/assets/css/js_composer_front.css?ver=3.7.3' type='text/css' media='all' />
         <link rel='stylesheet' id='rgs-css'  href='/wp-content/themes/salient/css/rgs.css?ver=4.5.2' type='text/css' media='all' />
        <link rel='stylesheet' id='font-awesome-css'  href='/wp-content/themes/salient/css/font-awesome.min.css?ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='steadysets-css'  href='/wp-content/themes/salient/css/steadysets.css?ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='linecon-css'  href='/wp-content/themes/salient/css/linecon.css?ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='main-styles-css'  href='/wp-content/themes/salient/style.css?ver=4.5.2' type='text/css' media='all' />
        <!--[if lt IE 9]>
        <link rel='stylesheet' id='nectar-ie8-css'  href='/wp-content/themes/salient/css/ie8.css?ver=4.0' type='text/css' media='all' />
        <![endif]-->
        <link rel='stylesheet' id='responsive-css'  href='/wp-content/themes/salient/css/responsive.css?ver=4.5.2' type='text/css' media='all' />
        <script type='text/javascript' src='/wp-includes/js/jquery/jquery.js?ver=1.11.1'></script>
        <script type='text/javascript' src='/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/modernizr.js?ver=2.6.2'></script>
        <link rel="EditURI" type="application/rsd+xml" title="RSD" href="/xmlrpc.php?rsd" />
        <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml" />
        <meta name="generator" content="WordPress 4.0" />
        <link rel='canonical' href='/privacy-policy/' />
        <link rel='shortlink' href='/?p=3085' />
        <link rel='stylesheet' href='/css/public.css'>
        <style type="text/css">
        </style>
        <style type="text/css">
            .recentcomments a {
                display: inline !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        </style>
        <meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress."/>
        {{ HTML::style('bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('bootstrap/css/bootstrap-theme.min.css') }}
        {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
    </head>

    <body class="@yield('classes')@show page page-id-3085 page-template-default wpb-js-composer js-comp-ver-3.7.3 vc_responsive" data-ajax-transitions="false" data-loading-animation="none" data-bg-header="false" data-ext-responsive="true" data-header-resize="1" data-header-color="light" data-transparent-header="false" data-smooth-scrolling="0" data-responsive="1" >
        @include('_helpers/analytics')
        <div id="header-space"></div>

        <div id="header-outer"  data-cart="false" data-transparency-option="0" data-shrink-num="6" data-full-width="false" data-using-secondary="0" data-using-logo="1" data-logo-height="" data-padding="28" data-header-resize="1">

            <div id="search-outer" class="nectar">

                <div id="search">

                    <div class="container">

                        <div id="search-box">

                            <div class="col span_12">
                                <form action="/" method="GET">
                                    <input type="text" name="s" id="s" value="Start Typing..." data-placeholder="Start Typing..." />
                                </form>
                            </div><!--/span_12-->

                        </div><!--/search-box-->

                        <div id="close">
                            <a href="#"><span class="icon-salient-x" aria-hidden="true"></span></a>
                        </div>

                    </div><!--/container-->

                </div><!--/search-->

            </div><!--/search-outer-->
            <header id="top">

                <div class="container">

                    <div class="row">

                        <div class="col span_3">
                        	
                            <a id="logo" href="/" > <img class=" dark-version" alt="SociallyMobile" src="/img/socially-mobile-logo.png" height="48" width="169" /> <!-- <div id="lets-talk">Let's Talk.</div> --></a>

                        </div><!--/span_3-->

                        <div class="col span_9 col_last">

                            <a href="#mobilemenu" id="toggle-nav"><i class="icon-reorder"></i></a>

                            <nav>
                                <ul class="sf-menu">
                                    <li id="menu-item-3074" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3074">
                                        <a href="/contact-us/">Contact Us</a>
                                    </li>
                                    <li id="menu-item-3251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3251">
                                        <a href="/public-events">Events</a>
                                    </li>
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
				                    @if (isset($pages))
										@foreach ($pages as $page)
											<li><a href="/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
										@endforeach
									@endif
                                    <li id="menu-item-3215" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3215">
                                        @if (!Auth::check())
                                        	<a href="<?php echo url() ?>/login">Log In</a>
                                        @else
                                        	<a href="/dashboard">Dashboard</a>
                                        @endif
                                    </li>
                                    <!-- <li id="search-btn">
                                        <div>
                                            <a href="#searchbox"><span class="icon-salient-search" aria-hidden="true"></span></a>
                                        </div>
                                    </li> -->
                                </ul>
                            </nav>

                        </div><!--/span_9-->

                    </div><!--/row-->

                </div><!--/container-->

            </header>

            <div class="ns-loading-cover"></div>

        </div><!--/header-outer-->

        <div id="mobile-menu">

            <div class="container">
                <ul>
                    <li id="menu-item-3074" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3074">
                        <a href="/contact-us/">Contact Us</a>
                    </li>
                    <li id="menu-item-3251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3251">
                        <a href="/public-events">Events</a>
                    </li>
					@foreach ($pages as $page)
						<li><a href="/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
					@endforeach
                    <li id="menu-item-3215" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3215">
                        @if (!Auth::check())
                        	<a href="<?php echo url() ?>/login">Log In</a>
                        @else
                        	<a href="/dashboard">Dashboard</a>
                        @endif
                    </li>
                    <!-- <li id="search-btn">
                        <div>
                            <a href="#searchbox"><span class="icon-salient-search" aria-hidden="true"></span></a>
                        </div>
                    </li> -->
                </ul>
            </div>

        </div>

        <div id="ajax-loading-screen">
            <span class="loading-icon "> <span class="default-skin-loading-icon"></span> </span>
        </div>
        <div id="ajax-content-wrap">

            <div class="container-wrap">

                <div class="container main-content">
                	<div class="row">
                		@include('_helpers.errors')
                		@include('_helpers.message')
	                	@section('content')
	                	@show
                	</div><!--/row-->
                </div><!--/container-->

            </div>

            <div id="footer-outer">

                <div class="row" id="copyright">

                    <div class="container">

                        <div class="col span_5">

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
							<br>
                            <p id="copyright-text">&copy; {{ date('Y') }} SociallyMobile</p>

                        </div><!--/span_5-->

                        <div class="col span_7 col_last">
                            <ul id="social"></ul>
                        </div><!--/span_7-->

                    </div><!--/container-->

                </div><!--/row-->

            </div><!--/footer-outer-->

        </div>
        <!--/ajax-content-wrap-->

        <a id="to-top"><i class="icon-angle-up"></i></a>

        <script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.core.min.js?ver=1.10.4'></script>
        <script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.widget.min.js?ver=1.10.4'></script>
        <script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.position.min.js?ver=1.10.4'></script>
        <script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.menu.min.js?ver=1.10.4'></script>
        <script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.autocomplete.min.js?ver=1.10.4'></script>
        <script type='text/javascript'>
/* <![CDATA[ */
var MyAcSearch = {"url":"http:\/\/sociallymobile-wordpress\/wp-admin\/admin-ajax.php"};
/* ]]> */
        </script>
        <script type='text/javascript' src='/wp-content/themes/salient/nectar/assets/functions/ajax-search/wpss-search-suggest.js'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/superfish.js?ver=1.4.8'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/respond.js?ver=1.1'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/sticky.js?ver=1.0'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/prettyPhoto.js?ver=4.5.2'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/wpbakery/js_composer/assets/lib/flexslider/jquery.flexslider-min.js?ver=3.7.3'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/isotope.min.js?ver=2.0'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/carouFredSel.min.js?ver=6.2'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/appear.js?ver=1.0'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/init.js?ver=4.5.2'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/js/nectar-slider.js?ver=4.5.2'></script>
        <script type='text/javascript'>
/* <![CDATA[ */
var nectarLove = {"ajaxurl":"http:\/\/sociallymobile-wordpress\/wp-admin\/admin-ajax.php","postID":"3085","rooturl":"http:\/\/sociallymobile-wordpress","pluginPages":[],"disqusComments":"false"};
/* ]]> */
        </script>
        <script type='text/javascript' src='/wp-content/themes/salient/nectar/love/js/nectar-love.js?ver=1.0'></script>
        <script type='text/javascript' src='/wp-content/themes/salient/wpbakery/js_composer/assets/js/js_composer_front.js?ver=3.7.3'></script>
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js') }}
        {{ HTML::script('/packages/dirpagination/dirPagination.js') }}
		{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js') }}
		@if (!Session::has('timezone'))
			<!-- get timezone -->
			<script>
			    // if (localStorage['timezone'] == undefined) {
			        // get timezone
			        var tz = jstz.determine();
			        // Determines the time zone of the browser client
			        var timezone = tz.name();
			        //'Asia/Kolhata' for Indian Time.
			        jQuery.post('/set-timezone', { timezone : timezone });
			    // }
			</script>
		@endif
		@section('scripts')
		@show
    </body>
</html>
@include('_helpers.store_previous_pages')
