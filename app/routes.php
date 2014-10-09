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

Route::get('/', function()
{
	return View::make('hello');
});
Route::group(array('domain' => '{account}.myapp.com'), function()
{

    Route::get('user/{id}', function($account, $id)
    {
        //
    });

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
Route::resource('payment', 'PaymentController');
Route::resource('payments', 'PaymentController');
Route::get('pre-register/{code}', 'PreRegisterController@create');
Route::resource('pre-register', 'PreRegisterController',['only' => ['create','store']]);

//Sessions controller
Route::get('login',array('as' => 'login','uses' => 'SessionController@create'));
Route::get('logout',array('as' => 'logout','uses' => 'SessionController@destroy'));
Route::get('sign-up/{code}',array('as' => 'sign-up','uses' => 'UserController@create'));
Route::resource('sessions','SessionController',['only' => ['create','destroy','store']]);

Route::get('test', function(){
	return App::environment();
});
Route::resource('productCategory', 'ProductCategoryController');

