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
//use SociallyMobile\Payments\USAEpayment;

##############################################################################################
# Session Control
##############################################################################################
Route::get('login', array('as' => 'login', 'uses' => 'SessionController@create'));
Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@destroy'));
Route::get('sign-up/{code}', array('as' => 'sign-up', 'uses' => 'UserController@create'));
Route::resource('sessions', 'SessionController', ['only' => ['create', 'destroy', 'store']]);
Route::controller('password', 'RemindersController');

##############################################################################################
# Replicated Site Routes
##############################################################################################
Route::group(array('domain' => '{subdomain}.{domain}', 'before' => 'rep-site'), function($subdomain)
{
    //dd($domain);
    
    Route::get('/', function($subdomain)
    {
		$user = User::where('public_id', $subdomain)->first();
		$userSite = UserSite::where('user_id', $user->id)->first();
		return View::make('userSite.show', compact('user', 'userSite'));
    });

});

##############################################################################################
# Public Routes
##############################################################################################

	Route::get('/', ['as' => 'home', function() {
		if (Auth::check()) {
			return Redirect::to('dashboard');
		}
		else {
			return View::make('sessions.create');
		}
	}]);
	
	// rep site
	Route::get('/a/{public_id}', 'UserSiteController@show');

	// blasts
	Route::get('send_text/{phoneId}','SmsMessagesController@create');
	Route::resource('send_text','SmsMessagesController');
	Route::get('send_mail/{personId}','MailMessagesController@create');
	Route::resource('send_mail/','MailMessagesController');
	Route::get('blast_email',['as'=>'blast_email','uses'=>'BlastController@CreateMail']);
	Route::post('blast_email',['uses'=>'BlastController@StoreMail']);
	Route::get('blast_sms',['as'=>'blast_sms','uses'=>'BlastController@CreateSms']);
	Route::post('blast_sms',['uses'=>'BlastController@StoreSms']);

##############################################################################################
// Protected Routes
##############################################################################################
Route::group(array('before' => 'auth'), function() {

	// dashboard
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
	Route::get('settings', 'DashboardController@settings');

	// downline
	Route::get('/downline/immediate/{id}', 'DownlineController@immediateDownline');
	Route::get('/downline/all/{id}', 'DownlineController@allDownline');
	Route::get('/downline/visualization/{id}', 'DownlineController@visualization');

	// users
	Route::resource('users', 'UserController');
	Route::post('users/email', 'BlastController@createMail');
	Route::post('users/sms', 'BlastController@createSms');

	// events

	Route::resource('events', 'UventController');
	Route::post('events/disable', 'UventController@disable');
	Route::post('events/enable', 'UventController@enable');
	Route::post('events/delete', 'UventController@delete');

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
	Route::get('api/all-events', 'DataOnlyController@getAllUvents');
	Route::get('api/all-events-by-role', 'DataOnlyController@getAllUventsByRole');
	Route::get('api/immediate-downline/{id}', 'DataOnlyController@getImmediateDownline');
	Route::get('api/all-downline/{id}', 'DataOnlyController@getAllDownline');
	Route::controller('api','DataOnlyController');


	Route::controller('api','DataOnlyController');

	// userSites
	Route::resource('user-sites', 'UserSiteController');

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
		
		// user
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
		
		// userSites
		Route::post('userSites/disable', 'UserSiteController@disable');
		Route::post('userSites/enable', 'UserSiteController@enable');
		Route::post('userSites/delete', 'UserSiteController@delete');

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

Route::get('populate-levels', function(){
	$level_count = Level::all()->count();
	if($level_count > 0)
	{
		return $level_count;
	}
	else
	{
		$frontline = User::find(0)->frontline;
		foreach(User::find(0)->frontline as $rep)
		{
			Commission::set_levels_down($rep->id,1);
		}
		return "Populated Levels";
	}

});
##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test-steve', function() {
	echo Hash::make('password2');
});

Route::get('test', function() {
	//Commission::get_org_tree_2(2008);
	//return Commission::get_org_tree(2001);

});
