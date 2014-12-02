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
# Non-Replicated Site Routes
##############################################################################################
Route::group(array('domain' => Config::get('site.domain'), 'before' => 'pub-site'), function()
{
	##############################################################################################
	# Session Control
	##############################################################################################
	Route::get('login', array('as' => 'login', 'uses' => 'SessionController@create'));
	Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@destroy'));
	Route::get('sign-up/{code}', array('as' => 'sign-up', 'uses' => 'UserController@create'));
	Route::resource('sessions', 'SessionController', ['only' => ['create', 'destroy', 'store']]);
	Route::controller('password', 'RemindersController');

	##############################################################################################
	# Public Routes
	##############################################################################################

	// company
	Route::get('/', ['as' => 'home', function() {
		// if (Auth::check()) {
			// return Redirect::to('dashboard');
		// }
		// else {
			return View::make('company.home');
		//}
	}]);
	Route::get('company-events', function() {
		return View::make('company.events');
	});
	Route::get('contact-us', function() {
		return View::make('company.contact-us');
	});
	Route::get('terms-conditions', function() {
		return View::make('company.terms');
	});
	Route::get('privacy-policy', function() {
		return View::make('company.privacy');
	});
	


	// blasts
	Route::get('send_text/{phoneId}','SmsMessagesController@create');
	Route::resource('send_text','SmsMessagesController');
	Route::get('send_mail/{personId}','MailMessagesController@create');
	Route::resource('send_mail/','MailMessagesController');
	Route::get('blast_email',['as'=>'blast_email','uses'=>'BlastController@CreateMail']);
	Route::post('blast_email',['uses'=>'BlastController@StoreMail']);
	Route::get('blast_sms',['as'=>'blast_sms','uses'=>'BlastController@CreateSms']);
	Route::post('blast_sms',['uses'=>'BlastController@StoreSms']);

	// contact form
	Route::post('send-contact-form',['as' => 'send-contact-form', 'uses' => 'ContactController@send']);

	// leads
	Route::resource('leads', 'LeadController');

	// events
	Route::get('public-events', 'UventController@publicIndex');
	Route::get('public-events/{id}', 'UventController@publicShow');

	// opportunities (public view)
	Route::get('opportunity/{id}', function($id)
	{
		$opportunity = Opportunity::findOrFail($id);
		$sponsor = User::where('id', 0)->first();
		return View::make('opportunity.public', compact('opportunity','sponsor'));
	});

	Route::controller('api','DataOnlyController');
		
	##############################################################################################
	// Protected Routes
	##############################################################################################
	Route::group(array('before' => 'auth'), function() {

		// dashboard
		Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
		Route::get('settings', ['as' => 'settings', 'uses' => 'DashboardController@settings']);

		// downline
		Route::get('/downline/immediate/{id}', 'DownlineController@immediateDownline');
		Route::get('/downline/all/{id}', 'DownlineController@allDownline');
		Route::get('/downline/visualization', 'DownlineController@visualization');

		// users
		Route::resource('users', 'UserController');
		Route::post('users/email', 'BlastController@createMail');
		Route::post('users/sms', 'BlastController@createSms');
		Route::get('users/{id}/privacy', 'UserController@privacy');
		Route::post('users/updateprivacy/{id}', 'UserController@updatePrivacy');

		// events
		Route::resource('events', 'UventController');
		Route::post('events/disable', 'UventController@disable');
		Route::post('events/enable', 'UventController@enable');
		Route::post('events/delete', 'UventController@delete');
		Route::get('past-events', 'UventController@indexPast');
		
		// opportunities
		Route::resource('opportunities', 'OpportunityController');
		Route::post('opportunities/disable', 'OpportunityController@disable');
		Route::post('opportunities/enable', 'OpportunityController@enable');
		Route::post('opportunities/delete', 'OpportunityController@delete');

		// API
		Route::get('api/all-addresses', 'AddressController@getAllAddresses');
		Route::get('api/all-bonuses', 'BonusController@getAllBonuses');
		Route::get('api/all-carts', 'CartController@getAllCarts');
		Route::get('api/all-emailMessages', 'EmailMessageController@getAllEmailMessages');
		Route::get('api/all-images', 'ImageController@getAllImages');
		Route::get('api/all-leads', 'LeadController@getAllLeads');
		Route::get('api/all-levels', 'LevelController@getAllLevels');
		Route::get('api/all-opportunities', 'OpportunityController@getAllOpportunities');
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
		Route::get('api/all-userProducts', 'UserProductController@getAllUserProducts');
		Route::get('api/all-userRanks', 'UserRankController@getAllUserRanks');
		Route::get('api/all-events', 'DataOnlyController@getAllUvents');
		Route::get('api/immediate-downline/{id}', 'DataOnlyController@getImmediateDownline');
		Route::get('api/all-downline/{id}', 'DataOnlyController@getAllDownline');

		// userSites
		Route::resource('user-sites', 'UserSiteController');
		
		##############################################################################################
		# Superadmin, Admin, Editor routes
		##############################################################################################
		Route::group(array('before' => ['Superadmin','Admin','Editor']), function() {
			Route::post('leads/disable', 'LeadController@disable');
			Route::post('leads/enable', 'LeadController@enable');
			Route::post('leads/delete', 'LeadController@delete');
		});


		##############################################################################################
		# Superadmin only routes
		##############################################################################################
		Route::group(array('before' => 'Superadmin'), function() {

		});
		##############################################################################################
		# Admin only routes
		##############################################################################################
		Route::group(array('before' => 'Admin'), function() {
			
			// site-config
			Route::resource('config', 'SiteConfigController');

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
		DB::connection()->disableQueryLog();

		if($level_count > 0)
		{
			return $level_count;
		}
		else
		{
			Commission::set_levels_down(0);
			return "Populated Levels";
		}

	});
});
##############################################################################################
# Replicated Site Routes
##############################################################################################
Route::group(array('domain' => '{subdomain}.'.\Config::get('site.base_domain'), 'before' => 'rep-site'), function($subdomain)
{
	function ($subdomain){
	};

	Route::get('/', function($subdomain)
	{
		$user = User::where('public_id', $subdomain)->first();
		if ($user->image == '') $user->image = '/img/users/default-avatar.png';
		else $user->image = '/img/users/avatars/' . $user->image;
		$userSite = UserSite::firstOrNew(['user_id'=> $user->id]);
		$userSite->save();
		//return dd($userSite);
		if ((!isset($userSite->banner))||($userSite->banner == '')) $userSite->banner = '/img/users/default-banner.png';
		else $userSite->banner = '/img/users/banners/' . $userSite->banner;
		$events = Uvent::where('public', 1)->where('date_start', '>', time())->take(5)->get();
		$opportunities = Opportunity::where('public', 1)->where('deadline', '>', time())->orWhere('deadline', '')->take(5)->orderBy('updated_at', 'DESC')->get();
		// echo '<pre>'; print_r($opportunities->toArray()); echo '</pre>';
		// exit;
		return View::make('userSite.show', compact('user', 'userSite', 'opportunities', 'events'));
	});

	// opportunities (public view)
	Route::get('opportunity/{id}', function($subdomain, $domain, $id)
	{
		$opportunity = Opportunity::findOrFail($id);
		$sponsor = User::where('public_id', $subdomain)->first();
		return View::make('opportunity.public', compact('opportunity','sponsor'));
	});

});

##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test-steve', function() {
	return User::find(2008)->frontline;
});

Route::get('test', function() {
	return User::with('payments')->take(200)->get();
	return Payment::take(1)->get();
	var_dump($payment);
	exit;
	$reps = User::all();
	foreach($reps as $rep)
	{
		foreach($rep->plans as $plan)
		{
			if($plan->price > 0)
			{
				$payment = Payment::Create([
					'user_id'=>$rep->id,
					'amount'=>$plan->price,
					'details'=>'Test payment in the amount of '.$plan->price.' to figure out how to run commissions.'
				]);
				$payment->user()->associate($rep);
				$payment->save();
				//echo"<pre>"; print_r($payment->toArray()); echo"</pre>";
			}
			else
			{
				//echo"<pre>"; print_r($plan->toArray()); echo"</pre>";
			}
		}
		
	}
	return $reps;
	return User::find(2001)->plans;
});

Route::get('test-payments', function() {
	$reps = User::all();
	foreach($reps as $rep)
	{
		foreach($rep->plans as $plan)
		{
			if($plan->price > 0)
			{
				$payment = Payment::Create([
					'user_id'=>$rep->id,
					'amount'=>$plan->price,
					'details'=>'Test payment in the amount of '.$plan->price.' to figure out how to run commissions.',
					'created_at' => date('Y-m-d H:i:s',strtotime('last month'))
				]);
				$payment->user()->associate($rep);
				$payment->save();
				//echo"<pre>"; print_r($payment->toArray()); echo"</pre>";
			}
			else
			{
				//echo"<pre>"; print_r($plan->toArray()); echo"</pre>";
			}
		}
		
	}
	return $reps;
	return User::find(2001)->plans;
});

//Route::get('deploy',['as'=>'deploy', 'uses'=>'Server@deploy']);
