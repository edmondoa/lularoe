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
	return View::make('sessions.create');
}]);

##############################################################################################
// Protected Routes
##############################################################################################
Route::group(array('before' => 'auth'), function() {

	// dashboard
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
	// users
	Route::resource('user', 'UserController');
	Route::resource('users', 'UserController');
	// products
	Route::resource('product', 'ProductController');
	Route::resource('products', 'ProductController');

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

	##############################################################################################
	# Superadmin only routes
	##############################################################################################
	Route::group(array('before' => 'Superadmin'), function() {

	});
	##############################################################################################
	# Admin only routes
	##############################################################################################
	Route::group(array('before' => 'Admin'), function() {
		// users
		Route::post('user/disable', 'UserController@disable');
		Route::post('user/enable', 'UserController@enable');
		Route::post('user/delete', 'UserController@delete');

		//products
		Route::post('product/disable', 'ProductController@disable');
		Route::post('product/enable', 'ProductController@enable');
		Route::post('product/delete', 'ProductController@delete');

		Route::resource('address', 'AddressController');
		Route::resource('addresses', 'AddressController');
		Route::resource('level', 'LevelController');
		Route::resource('levels', 'LevelController');
		Route::resource('role', 'RoleController');
		Route::resource('roles', 'RoleController');
		Route::resource('rank', 'RankController');
		Route::resource('ranks', 'RankController');
		Route::resource('userRank', 'UserRankController');
		Route::resource('userRanks', 'UserRankController');
		Route::resource('profile', 'ProfileController');
		Route::resource('profiles', 'ProfileController');
		Route::resource('cart', 'CartController');
		Route::resource('carts', 'CartController');
		Route::resource('userProduct', 'UserProductController');
		Route::resource('userProducts', 'UserProductController');
		Route::resource('review', 'ReviewController');
		Route::resource('reviews', 'ReviewController');
		Route::resource('mobilePlan', 'MobilePlanController');
		Route::resource('mobilePlans', 'MobilePlanController');
		Route::resource('bonus', 'BonusController');
		Route::resource('bonuses', 'BonusController');
		Route::resource('commission', 'CommissionController');
		Route::resource('commissions', 'CommissionController');
		Route::resource('page', 'PageController');
		Route::resource('pages', 'PageController');
		Route::resource('content', 'ContentController');
		Route::resource('contents', 'ContentController');
		Route::resource('image', 'ImageController');
		Route::resource('images', 'ImageController');
		Route::resource('sale', 'SaleController');
		Route::resource('sales', 'SaleController');
		Route::resource('emailMessage', 'EmailMessageController');
		Route::resource('emailMessages', 'EmailMessageController');
		Route::resource('smsMessage', 'SmsMessageController');
		Route::resource('smsMessages', 'SmsMessageController');
		Route::resource('emailRecipient', 'EmailRecipientController');
		Route::resource('emailRecipients', 'EmailRecipientController');
		Route::resource('smsRecipient', 'SmsRecipientController');
		Route::resource('smsRecipients', 'SmsRecipientController');
		Route::resource('payment', 'PaymentsController');
		Route::resource('payments', 'PaymentsController');

		Route::resource('productCategory', 'ProductCategoryController');

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

Route::get('test', function() {
	return User::find(2001)->toArray();
	//$result[] = count(User::find(2001)->children);
	//$result[] = count(User::find(2878)->children);
	//$result[] = count(User::find(3407)->children);
	//$result[] = count(User::find(3966)->children);
	//return $result;
	//return Commission::set_levels_down(2878,1);
	//return Commission::set_levels_down(3407,1);
	//return Commission::set_levels_down(3966,1);
	//return Commission::set_levels_down(3966,1);
	//return Commission::set_levels_down(2001,1);
	//$level = Commission::count_up(2014);
	//$level = Commission::level_up(2014);
	echo"<pre>"; print_r($level); echo"</pre>";
	exit;
	return dd($level);
});
