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
	##############################################################################################
	# Superadmin only routes
	##############################################################################################
	Route::group(array('before' => 'superadmin'), function(){

	});
	##############################################################################################
	# Admin only routes
	##############################################################################################
	Route::group(array('before' => 'admin'), function(){

	});
	##############################################################################################
	# Editor only routes
	##############################################################################################
	Route::group(array('before' => 'editor'), function(){

	});
	##############################################################################################
	# Rep only routes
	##############################################################################################
	Route::group(array('before' => 'rep'), function(){

	});
	##############################################################################################
	# Customer only routes
	##############################################################################################
	Route::group(array('before' => 'customer'), function(){

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
	Route::get('join', 'PreRegisterController@sponsor');
	Route::get('join/{public_id}', 'PreRegisterController@create');
	Route::resource('join', 'PreRegisterController',['only' => ['create','store']]);
});

// dashboard
Route::get('dashboard', 'DashboardController@index');

Route::resource('user', 'UserController');
Route::resource('users', 'UserController');
Route::post('user/disable/{id}', 'UserController@disable');
Route::post('user/enable/{id}', 'UserController@enable');
Route::delete('user/delete/{id}', 'UserController@delete');
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
Route::resource('product', 'ProductController');
Route::resource('products', 'ProductController');
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

##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test', function(){
	return Config::get('site.preregistration_fee');
});
