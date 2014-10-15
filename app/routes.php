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
Route::get('login',array('as' => 'login','uses' => 'SessionController@create'));
Route::get('logout',array('as' => 'logout','uses' => 'SessionController@destroy'));
Route::get('sign-up/{code}',array('as' => 'sign-up','uses' => 'UserController@create'));
Route::resource('sessions','SessionController',['only' => ['create','destroy','store']]);

##############################################################################################
# Home Page
##############################################################################################
Route::get('/',['as'=>'home', function()
{
	return View::make('sessions.create');
}]);


##############################################################################################
// Protected Routes
##############################################################################################
Route::group(array('before' => 'auth'), function()
{
	
	// dashboard
	Route::get('dashboard',['as'=>'dashboard','uses'=> 'DashboardController@index']);
	// users
	Route::resource('user', 'UserController');
	Route::resource('users', 'UserController');
	// products
	Route::resource('product', 'ProductController');
	Route::resource('products', 'ProductController');
	Route::get('api/all-products', 'ProductController@getAllProducts');
	
	##############################################################################################
	# Superadmin only routes
	##############################################################################################
	Route::group(array('before' => 'Superadmin'), function(){

	});
	##############################################################################################
	# Admin only routes
	##############################################################################################
	Route::group(array('before' => 'Admin'), function(){
		// users
		Route::post('user/disable', 'UserController@disable');
		Route::post('user/enable', 'UserController@enable');
		Route::post('user/delete', 'UserController@delete');
		
		//products
		Route::post('product/disable', 'ProductController@disable');
		Route::post('product/enable', 'ProductController@enable');
		Route::post('product/delete', 'ProductController@delete');
		
		Route::resource('address', 'AddresseController');
		Route::resource('addresses', 'AddresseController');
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
		Route::resource('bonus', 'BonuseController');
		Route::resource('bonuses', 'BonuseController');
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

Route::group(['before' => 'force.ssl'], function()
{
	//Route::get('join', 'PreRegisterController@sponsor');
	Route::get('join/{public_id}', 'PreRegisterController@create');
	Route::get('join', 'PreRegisterController@create');
	Route::post('find-sponsor', 'PreRegisterController@redirect');
	Route::resource('join', 'PreRegisterController',['only' => ['create','store']]);
});

##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test', function() {
	return View::make('test');
});
