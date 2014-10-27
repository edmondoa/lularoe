<?php

/*
 |--------------------------------------------------------------------------
 | Application Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register all of the routes for an application.
 | It's a breeze. Simply tell Laravel the URIs it should respond to
 | and give it the Closure to execute when that URI is requested.
 |
 */
use SociallyMobile\Payments\USAEpayment;

##############################################################################################
# Session Control
##############################################################################################
Route::get('login', array('as' => 'login', 'uses' => 'SessionController@create'));
Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@destroy'));
Route::get('sign-up/{code}', array('as' => 'sign-up', 'uses' => 'UserController@create'));
Route::resource('sessions', 'SessionController', ['only' => ['create', 'destroy', 'store']]);

##############################################################################################
# Home Page
##############################################################################################

	Route::get('/', ['as' => 'home', function() {
		if (Auth::check()) {
			return Redirect::to('dashboard');
		}
		else {
			return View::make('sessions.create');
		}
	}]);

##############################################################################################
// Protected Routes
##############################################################################################
Route::group(array('before' => 'auth'), function() {

	// dashboard
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

	// downline
	Route::get('/downline/immediate/{id}', 'DownlineController@immediateDownline');
	Route::get('/downline/all/{id}', 'DownlineController@allDownline');

	// API
	Route::get('api/all-addresses', 'AddressController@getAllAddresses');
	Route::get('api/all-bonuses', 'BonusController@getAllBonuses');
	Route::get('api/all-carts', 'CartController@getAllCarts');
	Route::get('api/all-emailMessages', 'EmailMessageController@getAllEmailMessages');
	Route::get('api/all-images', 'ImageController@getAllImages');
	Route::get('api/all-levels', 'LevelController@getAllLevels');
	Route::get('api/all-pages', 'PageController@getAllPages');
	Route::get('api/all-products', 'ProductController@getAllProducts');
	Route::get('api/all-productCategories', 'ProductCategoryController@getAllProductCategories');
	Route::get('api/all-profiles', 'ProfileController@getAllProfiles');
	Route::get('api/all-ranks', 'RankController@getAllRanks');
	Route::get('api/all-reviews', 'ReviewController@getAllReviews');
	Route::get('api/all-roles', 'ReviewController@getAllRoles');
	Route::get('api/all-sales', 'SaleController@getAllSales');
	Route::get('api/all-smsMessages', 'SmsMessageController@getAllSmsMessages');
	Route::get('api/all-states', 'StateController@getAllStates');
	Route::get('api/all-users', 'UserController@getAllUsers');
	Route::get('api/all-userProducts', 'UserProductController@getAllUserProducts');
	Route::get('api/all-userRanks', 'UserRankController@getAllUserRanks');
	Route::get('api/immediate-downline/{id}', 'DataOnlyController@getImmediateDownline');
	Route::get('api/all-downline/{id}', 'DataOnlyController@getAllDownline');

	##############################################################################################
	# Superadmin only routes
	##############################################################################################
	Route::group(array('before' => 'Superadmin'), function() {

	});
	##############################################################################################
	# Admin only routes
	##############################################################################################
	Route::group(array('before' => 'Admin'), function() {
		
		// addresses
		Route::resource('addresses', 'AddressController');
		Route::post('addresses/disable', 'AddressController@disable');
		Route::post('addresses/enable', 'AddressController@enable');
		Route::post('addresses/delete', 'AddressController@delete');
		
		// bonuses
		Route::resource('bonuses', 'BonusController');
		Route::post('bonuses/disable', 'BonusController@disable');
		Route::post('bonuses/enable', 'BonusController@enable');
		Route::post('bonuses/delete', 'BonusController@delete');
		
		// carts
		Route::resource('carts', 'CartController');
		Route::post('carts/disable', 'CartController@disable');
		Route::post('carts/enable', 'CartController@enable');
		Route::post('carts/delete', 'CartController@delete');
		
		// commissions
		Route::resource('commissions', 'CommissionController');
		Route::post('commissions/disable', 'CommissionController@disable');
		Route::post('commissions/enable', 'CommissionController@enable');
		Route::post('commissions/delete', 'CommissionController@delete');
		
		// emailMessages
		Route::resource('emailMessages', 'EmailMessageController');
		Route::post('emailMessages/disable', 'EmailMessageController@disable');
		Route::post('emailMessages/enable', 'EmailMessageController@enable');
		Route::post('emailMessages/delete', 'EmailMessageController@delete');
		
		// emailRecipients	
		Route::resource('emailRecipients', 'EmailRecipientController');
		Route::post('emailRecipients/disable', 'EmailRecipientController@disable');
		Route::post('emailRecipients/enable', 'EmailRecipientController@enable');
		Route::post('emailRecipients/delete', 'EmailRecipientController@delete');
		
		// images			
		Route::resource('images', 'ImageController');
		Route::post('images/disable', 'ImageController@disable');
		Route::post('images/enable', 'ImageController@enable');
		Route::post('images/delete', 'ImageController@delete');
		
		// levels
		Route::resource('levels', 'LevelController');
		Route::post('levels/disable', 'LevelController@disable');
		Route::post('levels/enable', 'LevelController@enable');
		Route::post('levels/delete', 'LevelController@delete');	
		
		// mobile plans
		Route::resource('mobilePlans', 'MobilePlanController');
		Route::post('mobilePlans/disable', 'MobilePlanController@disable');
		Route::post('mobilePlans/enable', 'MobilePlanController@enable');
		Route::post('mobilePlans/delete', 'MobilePlanController@delete');
		
		// pages
		Route::resource('pages', 'PageController');
		Route::post('pages/disable', 'PageController@disable');
		Route::post('pages/enable', 'PageController@enable');
		Route::post('pages/delete', 'PageController@delete');
		
		// products
		Route::resource('products', 'ProductController');
		Route::post('products/disable', 'ProductController@disable');
		Route::post('products/enable', 'ProductController@enable');
		Route::post('products/delete', 'ProductController@delete');
		
		// productCategories
		Route::resource('productCategories', 'ProductCategoryController');
		Route::post('productCategories/disable', 'ProductCategoryController@disable');
		Route::post('productCategories/enable', 'ProductCategoryController@enable');
		Route::post('productCategories/delete', 'ProductCategoryController@delete');
		
		// profile
		Route::resource('profiles', 'ProfileController');
		Route::post('profiles/disable', 'ProfileController@disable');
		Route::post('profiles/enable', 'ProfileController@enable');
		Route::post('profiles/delete', 'ProfileController@delete');
		
		// ranks
		Route::resource('ranks', 'RankController');
		Route::post('ranks/disable', 'RankController@disable');
		Route::post('ranks/enable', 'RankController@enable');
		Route::post('ranks/delete', 'RankController@delete');

		// reviews
		Route::resource('reviews', 'ReviewController');
		Route::post('reviews/disable', 'ReviewController@disable');
		Route::post('reviews/enable', 'ReviewController@enable');
		Route::post('reviews/delete', 'ReviewController@delete');

		// roles
		Route::resource('roles', 'RoleController');
		Route::post('roles/disable', 'RoleController@disable');
		Route::post('roles/enable', 'RoleController@enable');
		Route::post('roles/delete', 'RoleController@delete');
		
		// sales
		Route::resource('sales', 'SaleController');
		Route::post('sales/disable', 'SaleController@disable');
		Route::post('sales/enable', 'SaleController@enable');
		Route::post('sales/delete', 'SaleController@delete');
		
		// smsMessages
		Route::resource('smsMessages', 'SmsMessageController');
		Route::post('smsMessages/disable', 'SmsMessageController@disable');
		Route::post('smsMessages/enable', 'SmsMessageController@enable');
		Route::post('smsMessages/delete', 'SmsMessageController@delete');
		
		// smsRecipients
		Route::resource('smsRecipients', 'SmsRecipientController');
		Route::post('smsRecipients/disable', 'SmsRecipientController@disable');
		Route::post('smsRecipients/enable', 'smsRecipientController@enable');
		Route::post('smsRecipients/delete', 'smsRecipientController@delete');
		
		// users
		Route::resource('users', 'UserController');
		Route::post('users/disable', 'UserController@disable');
		Route::post('users/enable', 'UserController@enable');
		Route::post('users/delete', 'UserController@delete');
		
		// userProduct
		Route::resource('userProducts', 'UserProductController');
		Route::post('userProducts/disable', 'UserProductController@disable');
		Route::post('userProducts/enable', 'UserProductController@enable');
		Route::post('userProducts/delete', 'UserProductController@delete');
		
		// userRanks
		Route::resource('userRanks', 'UserRankController');
		Route::post('userRanks/disable', 'UserRankController@disable');
		Route::post('userRanks/enable', 'UserRankController@enable');
		Route::post('userRanks/delete', 'UserRankController@delete');

	});
	##############################################################################################
	# Editor only routes
	##############################################################################################
	Route::group(array('before' => 'Editor'), function() {

	});
	##############################################################################################
	# Rep only routes
	##############################################################################################
	Route::group(array('before' => 'Rep'), function() {

	});
	##############################################################################################
	# Customer only routes
	##############################################################################################
	Route::group(array('before' => 'Customer'), function() {

	});
});
##############################################################################################
# Public Routes
##############################################################################################

##############################################################################################
# Secure Routes
##############################################################################################

Route::group(['before' => 'force.ssl'], function() {
	//Route::get('join', 'PreRegisterController@sponsor');
	Route::get('join/{public_id}', 'PreRegisterController@create');
	Route::get('join', 'PreRegisterController@create');
	Route::post('find-sponsor', 'PreRegisterController@redirect');
	Route::resource('join', 'PreRegisterController', ['only' => ['create', 'store']]);
});

##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test-steve/{id}', function($id) {
	$users = User::find($id)->descendants;
	echo"<pre>"; print_r($users->toArray()); echo"</pre>";
	exit;
});

Route::get('test', function() {
	return User::find(2001)->frontline;
	//$result[] = count(User::find(2001)->children);
	//$result[] = count(User::find(2878)->children);
	//$result[] = count(User::find(3407)->children);
	//$result[] = count(User::find(3966)->children);
	//return $result;
	
	//return Commission::set_levels_down(2001,1);
	//return Commission::set_levels_down(2878,1);
	//return Commission::set_levels_down(3407,1);
	//return Commission::set_levels_down(3966,1);
	//return Commission::set_levels_down(3966,1);
	//return Commission::set_levels_down(2001,1);
	//$level = Commission::count_up(2014);

});
