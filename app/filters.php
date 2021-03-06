<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});



App::after(function($request, $response)
{
	//
});

// Force cache on some routes

Route::filter('cache.fetch','LLR\Filters\CacheFilter@fetch');
Route::filter('cache.put','LLR\Filters\CacheFilter@put');

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('customer', function(){
	if (!Auth::user()->hasRole('Customer'))
	{
		return App::abort('403', 'You are not authorized (Customer).');
	}
});

Route::filter('rep', function(){
	if (!Auth::user()->hasRole('Rep'))
	{
		return App::abort('403', 'You are not authorized (Rep).');
	}
});

Route::filter('editor', function(){
	if (!Auth::user()->hasRole('Editor'))
	{
		return App::abort('403', 'You are not authorized (Editor).');
	}
});

Route::filter('admin', function(){
	if (!Auth::user()->hasRole('Admin'))
	{
		return App::abort('403', 'You are not authorized (Admin).');
	}
});

Route::filter('superadmin', function(){
	if (!Auth::user()->hasRole('Superadmin'))
	{
		return App::abort('403', 'You are not authorized (other).');
	}
});

##############################################################################################
# Public filter
##############################################################################################
Route::filter('pub-site', function($router)
{

});

##############################################################################################
# replicated filter
##############################################################################################
Route::filter('rep-site', function($router)
{
	//dd($domain);
	if(in_array($router->parameter('subdomain'),Config::get('site.locked_subdomains'))) return;
	if (User::where('public_id',$router->parameter('subdomain'))->count() != 1)
	{
		return Redirect::to('http://'.Config::get('site.domain'));
	}
});

/*
|--------------------------------------------------------------------------
| Force Https requests
|--------------------------------------------------------------------------
*/
 
Route::filter('force.ssl', function()
{
	if( ! Request::secure() && App::environment() === 'production') // only use this for production
	{
		return Redirect::secure(Request::getRequestUri());
	}
 
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
