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

Route::resource('users', 'UsersController');
Route::resource('addresses', 'AddressesController');
Route::resource('levels', 'LevelsController');
Route::resource('roles', 'RolesController');
Route::resource('ranks', 'RanksController');
Route::resource('userRanks', 'UserRanksController');
Route::resource('profiles', 'ProfilesController');
Route::resource('products', 'ProductsController');
Route::resource('cart', 'CartController');
Route::resource('userProducts', 'UserProductsController');
Route::resource('reviews', 'ReviewsController');
Route::resource('mobilePlans', 'MobilePlansController');
Route::resource('bonuses', 'BonusesController');
Route::resource('commissions', 'CommissionsController');
Route::resource('pages', 'PagesController');
Route::resource('content', 'ContentController');
Route::resource('images', 'ImagesController');
Route::resource('sales', 'SalesController');
Route::resource('emailMessages', 'EmailMessagesController');
Route::resource('smsMessages', 'SmsMessagesController');
Route::resource('emailRecipients', 'EmailRecipientsController');
Route::resource('smsRecipients', 'SmsRecipientsController');
Route::resource('payments', 'PaymentsController');

//Sessions controller
Route::get('login',array('as' => 'login','uses' => 'SessionsController@create'));
Route::get('logout',array('as' => 'logout','uses' => 'SessionsController@destroy'));
Route::get('sign-up/{code}',array('as' => 'sign-up','uses' => 'UsersController@create'));
Route::resource('sessions','SessionsController',['only' => ['create','destroy','store']]);