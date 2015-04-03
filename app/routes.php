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
	// load user-created pages
	/*
	$path = Request::path();
	if (Page::where('url', $path)->first()) {
		Route::get('/{' . $path . '}', 'PageController@show');
	}
	*/
//if((Auth::check())&&(Auth::user()->hasRole(['Rep']))) Auth::logout();
##############################################################################################
# Non-Replicated Site Routes
##############################################################################################
Route::controller('dev','DevelopController');
Route::pattern('id', '[0-9]+');

		// API for IOS App
		Route::get('llrapi/v1/auth/{login}', 						'ExternalAuthController@auth');
		Route::get('llrapi/v1/remove-inventory/{key}',			'ExternalAuthController@rmInventory');
		Route::get('llrapi/v1/remove-inventory/{key}/{id}/{quantity}',			'ExternalAuthController@rmInventory');

		Route::get('llrapi/v1/get-inventory/',					'ExternalAuthController@getInventory');
		Route::get('llrapi/v1/get-inventory/{key}',				'ExternalAuthController@getInventory');
		Route::get('llrapi/v1/get-inventory/{key}/{location}',	'ExternalAuthController@getInventory');
		Route::get('llrapi/v1/inventory/{location}',			'ExternalAuthController@getInventory');

		Route::get('llrapi/v1/refund/{key}', 					'ExternalAuthController@refund');
		Route::get('llrapi/v1/purchase/{key}',					'ExternalAuthController@purchase');
		Route::post('llrapi/v1/purchase/{key}',					'ExternalAuthController@purchase');
		Route::get('llrapi/v1/multi-purchase/{key}',			'ExternalAuthController@multiPurchase');
		Route::post('llrapi/v1/sendreceipt/{key}',				'ExternalAuthController@sendReceipt');

		Route::get('llrapi/v1/ledger/{key}', 					'ExternalAuthController@ledger');
		Route::get('llrapi/v1/ledger/',		 					'ExternalAuthController@ledger');

		Route::post('llrapi/v1/reorder/', 					    	'ExternalAuthController@reorder');

Route::group(array('domain' => Config::get('site.domain'), 'before' => 'pub-site'), function() {
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
		$title = 'Home';
		return View::make('company.home', compact('title'));
	}]);
	Route::get('contact-us', function() {
		$title = 'Contact Us';
		return View::make('company.contact-us', compact('title'));
	});
	Route::get('terms-conditions', function() {
		$title = 'Terms and Conditions';
		return View::make('company.terms', compact('title'));
	});
	Route::get('privacy-policy', function() {
		$title = 'Privacy Policy';
		return View::make('company.privacy', compact('title'));
	});
	Route::get('leadership', function() {
		$title = 'Leadership';
		return View::make('company.leadership', compact('title'));
	});
	Route::get('presentation', function() {
		$title = 'Presentation';
		return View::make('company.presentation', compact('title'));
	});
	
	// company website
	Route::get('company', function() {
		$title = 'Home';
		return View::make('site.home', compact('title'));
	});
	Route::get('terms-conditions', function() {
		$title = 'Terms and Conditions';
		return View::make('company.terms', compact('title'));
	});
	Route::get('privacy-policy', function() {
		$title = 'Privacy Policy';
		return View::make('company.privacy', compact('title'));
	});
	Route::get('leadership', function() {
		$title = 'Leadership';
		return View::make('company.leadership', compact('title'));
	});
	Route::get('presentation', function() {
		$title = 'Presentation';
		return View::make('company.presentation', compact('title'));
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
	Route::post('party-invite','BlastController@CreatePartyInvite');
	Route::post('party-host-invite','BlastController@CreatePartyHostInvite');
	Route::post('blast-party-invites',['as' => 'blast-party-invites', 'uses'=>'BlastController@StorePartyInvites']);
	Route::post('blast-party-host-invite',['as' => 'blast-party-host-invite', 'uses'=>'BlastController@StorePartyHostInvite']);

	// cart
	Route::get('cart', ['as' => 'cart', 'uses' => 'CartController@show']);
	Route::post('cart', 'CartController@store');
	Route::post('cart/remove/{index}', 'CartController@remove');
	Route::post('cart/change-quantity', 'CartController@changeQuantity');
	Route::get('api/cart', 'DataOnlyController@getCart');

	// contact form
	Route::post('send-contact-form',['as' => 'send-contact-form', 'uses' => 'ContactController@send']);

	// events
	Route::get('api/upcoming-public-events', 'DataOnlyController@getUpcomingPublicEvents');
	Route::get('public-events', 'UventController@publicIndex');
	Route::get('public-events/{id}', 'UventController@publicShow');

	// leads
	Route::get('leads', ['as' => 'leads', 'uses' => 'LeadController@index']);
	Route::resource('leads', 'LeadController');
	Route::post('leads/disable', 'LeadController@disable');
	Route::post('leads/enable', 'LeadController@enable');
	Route::post('leads/delete', 'LeadController@delete');

	// I hate my understaneding of how routes work
	Route::resource('bankinfo', 'BankinfoController');
	Route::post('bankinfo/store', 'BankinfoController@store');

	// opportunities (public view)
	Route::get('opportunity/{id}', function($id) {
		$opportunity = Opportunity::findOrFail($id);
		$sponsor = User::where('id', 0)->first();
		return View::make('opportunity.public', compact('opportunity','sponsor'));
	});

	// pages
	Route::resource('pages', 'PageController');
	Route::post('pages/disable', 'PageController@disable');
	Route::post('pages/enable', 'PageController@enable');
	Route::post('pages/delete', 'PageController@delete');
	
	// parties
	Route::get('public-parties', 'PartyController@publicIndex');
	Route::get('public-parties/{id}', 'PartyController@publicShow');
	Route::get('api/upcoming-public-parties', 'DataOnlyController@getUpcomingPublicParties');
	Route::get('party-rsvp/{party_id}/{person_id}/{person_type}/{status}', 'PartyController@RSVP');
	Route::get('party-decline/{party_id}/{person_id}/{person_type}/{status}', 'PartyController@RSVP');
	Route::get('host-rsvp/{party_id}/{person_id}/{person_type}/{status}', 'PartyController@hostRSVP');
	Route::get('host-decline/{party_id}/{person_id}/{person_type}/{status}', 'PartyController@hostRSVP');
	Route::get('party/{id}', 'PartyController@publicShow');
	
	// posts
	Route::resource('posts', 'PostController');
	Route::get('api/public-posts', 'DataOnlyController@getPublicPosts');
	Route::get('public-posts', 'PostController@publicIndex');
	Route::get('public-posts/{url}', 'PostController@publicShow');
	Route::post('posts/disable', 'PostController@disable');
	Route::post('posts/enable', 'PostController@enable');
	Route::post('posts/delete', 'PostController@delete');
	Route::get('api/public-posts', 'DataOnlyController@getPublicPosts');
	
	// products
	Route::get('store', 'ProductController@publicIndex');
	Route::get('store/{id}', 'ProductController@publicShow');
	Route::get('api/all-products', 'DataOnlyController@getAllProducts');

	Route::get('sales/consignment/{id}','SaleController@consignmentsale');
	Route::post('sales/consignment', 'SaleController@consignmentpurchase');

	// sales
	Route::resource('sales', 'SaleController');
	Route::get('sales/create', 'SaleController@create');
	Route::get('sales/checkout', 'SaleController@checkout');

	//timezone
	Route::post('set-timezone', 'TimezoneController@setTimezone');
		
	##############################################################################################
	// Protected Routes
	##############################################################################################
	Route::group(array('before' => 'auth'), function() {

		// addresses
		Route::resource('addresses', 'AddressController');
		Route::post('addresses/disable', 'AddressController@disable');
		Route::post('addresses/enable', 'AddressController@enable');
		Route::post('addresses/delete', 'AddressController@delete');
		Route::get('addresses/{id}/delete', 'AddressController@destroy');

		// attachments
		Route::get('delete-attachment/{id}', 'AttachmentController@destroy');

		// dashboard
		Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
		Route::get('settings', ['as' => 'settings', 'uses' => 'DashboardController@settings']);
        Route::get('welcome', ['as' => 'welcome', 'uses' => 'DashboardController@onboarding']);

		// downline
		Route::get('/downline/new/{id}', 'DownlineController@newDownline');
		Route::get('/downline/immediate/{id}', 'DownlineController@immediateDownline');
		Route::get('/downline/all/{id}', 'DownlineController@allDownline');
		Route::get('/downline/visualization/{id}', 'DownlineController@visualization');
		Route::get('/downline/states/{id}', 'DownlineController@states');
		
		// helpers
		Route::get('helpers/media-modals', function() {
			return View::make('_helpers/modals');
		});

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
		
		// Media
		Route::resource('media', 'MediaController');
		Route::get('media/user/{id}', ['as' => 'media/user', 'uses' => 'MediaController@user']);
		Route::get('media-reps', 'MediaController@reps');
		Route::get('media-shared-with-reps', 'MediaController@sharedWithReps');
		Route::get('media/destroy/{id}', 'MediaController@destroyAJAX');
		Route::post('media/disable', 'MediaController@disable');
		Route::post('media/enable', 'MediaController@enable');
		Route::post('media/delete', 'MediaController@delete');
		Route::get('media/ajax/{id}', 'MediaController@showAJAX');
		
        //inventories
        #Route::resource('inventories', 'InventoryController');
        Route::get('inventory/matrix/{group}', 'InventoryController@matrixFull');
        Route::get('inventories/', 'InventoryController@index');
        Route::get('inv/checkout', 'InventoryController@checkout');
        Route::get('inv/sales', 'InventoryController@sales');
		Route::get('inventory/full', 'InventoryController@matrixFull');

        Route::post('inv/invoice', 'InventoryController@sendInvoice');
		Route::get('invoice/pay/{id}', 'InventoryController@viewInvoice');

        Route::post('inv/purchase', 'InventoryController@purchase');
		Route::post('inv/achpurchase', 'InventoryController@achpurchase');
		Route::post('inv/cashpurchase', 'InventoryController@cashpurchase');
		Route::post('inv/conspurchase', 'InventoryController@conspurchase');
		#Route::post('inventories/disable', 'InventoryController@disable');
		#Route::post('inventories/enable', 'InventoryController@enable');
		#Route::post('inventories/delete', 'InventoryController@delete');
		Route::get('inventory/validpurchase', function() {
			return (View::make('inventory.validpurchase'));
		});
		Route::get('inventory/invalidpurchase', function() {
			return (View::make('inventory.invalidpurchase'));
		});
        
        Route::get('tax/{amount}', 'InventoryController@getTax');
        Route::get('discounts/{amount}', 'InventoryController@getDiscounts');
		// opportunities
		Route::resource('opportunities', 'OpportunityController');
		Route::post('opportunities/disable', 'OpportunityController@disable');
		Route::post('opportunities/enable', 'OpportunityController@enable');
		Route::post('opportunities/delete', 'OpportunityController@delete');

		// pricing
		Route::get('pricing', function() {
			return View::make('company.pricing');
		});

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

		// parties
		Route::resource('parties', 'PartyController');
		Route::post('parties/disable', 'PartyController@disable');
		Route::post('parties/enable', 'PartyController@enable');
		Route::post('parties/delete', 'PartyController@delete');
		Route::get('past-parties', 'PartyController@indexPast');

		##############################################################################################
		# API that should be cached
		##############################################################################################
		//Route::controller('api','DataOnlyController');
		//put routes in here that we would like to cache
		Route::group(['before' => 'cache.fetch'], function() {
			Route::group(['after' => 'cache.put'], function() {
				
				Route::get('cache-testing',function(){
					return 'jake_'.date('H:i:s');
				});
			});
		});

		##############################################################################################
		# API functions that shouldn't be cached
		##############################################################################################

        Route::get('api/all-downline/{id}', 'DataOnlyController@getAllDownline');
        Route::get('api/immediate-downline/{id}', 'DataOnlyController@getImmediateDownline');
        Route::get('api/all-users', 'DataOnlyController@getAllUsers');
        
        Route::get('api/all-bankinfos', 'BankinfoController@getAllBankInfos');
		Route::get('api/all-addresses', 'AddressController@getAllAddresses');
		Route::get('api/all-bonuses', 'BonusController@getAllBonuses');
		Route::get('api/all-carts', 'CartController@getAllCarts');
		Route::get('api/all-emailMessages', 'EmailMessageController@getAllEmailMessages');
		Route::get('api/all-leads', 'LeadController@getAllLeads');
		Route::get('api/all-levels', 'LevelController@getAllLevels');
		Route::get('api/all-opportunities', 'OpportunityController@getAllOpportunities');
		Route::get('api/all-pages', 'PageController@getAllPages');
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
		Route::get('api/all-media', 'DataOnlyController@getAllMedia');
		if (Auth::check() && Auth::user() -> hasRole(['Superadmin', 'Admin', 'Editor'])) :
			Route::get('api/media-counts/{id}', 'DataOnlyController@getMediaCounts');
		elseif (Auth::check() && Auth::user() -> hasRole(['Rep'])) :
			Route::get('api/media-counts/{type}', 'DataOnlyController@getMediaCounts');
		endif;
		Route::get('api/media-tags', 'DataOnlyController@getMediaTags');
		Route::get('api/all-images', 'DataOnlyController@getAllImages');
		Route::get('api/all-config', 'DataOnlyController@getAllConfig');
		Route::get('api/first-branch', 'DataOnlyController@getFirstBranch');
		Route::get('api/all-branches/{id}', 'DataOnlyController@getAllBranches');
		
		// media
		Route::get('api/media-by-user/{id}', 'DataOnlyController@getMediaByUser');
		Route::get('api/media-by-reps', 'DataOnlyController@getMediaByReps');
		Route::get('api/images-by-user/{id}', 'DataOnlyController@getImagesByUser');
		Route::get('api/media-shared-with-reps', 'DataOnlyController@getMediaSharedWithReps');
		Route::get('api/images-shared-with-reps', 'DataOnlyController@getImagesSharedWithReps');
		
		// events
		Route::get('api/all-events', 'DataOnlyController@getAllUvents');
		Route::get('api/all-upcoming-events', 'DataOnlyController@getAllUpcomingEvents');
		Route::get('api/all-upcoming-events-by-role', 'DataOnlyController@getAllUpcomingEventsByRole');
		Route::get('api/all-past-events', 'DataOnlyController@getAllPastEvents');
		Route::get('api/all-past-events-by-role', 'DataOnlyController@getAllPastEventsByRole');
		
		// parties
		Route::get('api/all-parties', 'DataOnlyController@getAllParties');
		Route::get('api/all-upcoming-parties', 'DataOnlyController@getAllUpcomingParties');
		Route::get('api/all-upcoming-parties-by-role', 'DataOnlyController@getAllUpcomingPartiesByRole');
		Route::get('api/all-past-parties', 'DataOnlyController@getAllPastParties');
		Route::get('api/all-past-parties-by-role', 'DataOnlyController@getAllPastPartiesByRole');
		Route::get('api/party/{id}', 'DataOnlyController@getParty');
		
		Route::get('api/all-opportunities', 'DataOnlyController@getAllOpportunities');
		Route::get('api/all-leads', 'DataOnlyController@getAllLeads');
		Route::get('api/all-leads-by-rep/{id}', 'DataOnlyController@getAllLeadsByRep');
		Route::get('api/all-pages', 'DataOnlyController@getAllPages');
		Route::get('api/all-posts', 'DataOnlyController@getAllPosts');
		Route::get('api/all-product-categories', 'DataOnlyController@getAllProductCategories');
		Route::get('api/all-product-tags', 'DataOnlyController@getAllProductTags');
		Route::get('api/new-downline/{id}', 'DataOnlyController@getNewDownline');		
		Route::get('api/all-items', 'DataOnlyController@getAllItems');	
        Route::get('api/search-user/{keyword}', 'DataOnlyController@getSearchUsers');    

		// tags
		Route::get('api/remove-tag/{id}', 'TagController@destroy');

		// upload media
		Route::post('upload-media', 'MediaController@store');

		// userSites
		Route::resource('user-sites', 'UserSiteController');
		
		##############################################################################################
		# Superadmin, Admin, Editor routes
		##############################################################################################
		Route::group(array('before' => ['superadmin','admin','editor']), function() {
			//Route::controller('dev','DevelopController');
		});

		##############################################################################################
		# Superadmin only routes
		##############################################################################################
		Route::group(array('before' => 'superadmin'), function() {
			Route::controller('sa','SuperAdminTasksController');
			Route::get('login-as/{id}',function($id){
				//first log out the admin
				if (!Auth::user() -> hasRole(['Superadmin']))
					return;
				Auth::logout();
				//then login automatically as the requested user
				Auth::loginUsingId($id);
				return Redirect::to('/dashboard');
			});
			Route::get('clear-all-cache', function() {
				$users = DB::table('users')->get(['id']);
				$count = 0;
				foreach ($users as $user) {
					$user = User::find($user->id);
					$user->clearUserCache();
					$count++;
				}
				return "Cache cleared for ".$count." users";
			});

		});
		##############################################################################################
		# Admin only routes
		##############################################################################################
		Route::group(array('before' => 'admin'), function() {
			
			// site-config
			Route::resource('config', 'SiteConfigController');
			
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

	// LLRDEV
	// Route::group(['before' => 'force.ssl'], function() {
	Route::group(array(), function() {
		//Route::get('join', 'PreRegisterController@sponsor');
		Route::get('join/{public_id}', 'PreRegisterController@create');
        Route::get('join', 'PreRegisterController@create');
        Route::get('pending-registration', 'PreRegisterController@pending');
        Route::post('change-password', 'PreRegisterController@changePassword');
		Route::post('add-product', 'PreRegisterController@addProduct');
        Route::get('u/{key}', 'PreRegisterController@verifyemail');
        Route::get('template/preregister/', 'PreRegisterController@template');
        Route::get('template/preregister/{key}', 'PreRegisterController@template');
        Route::get('bank-info', 'PreRegisterController@bankinfo');
        Route::post('bank-info', 'PreRegisterController@updatebankinfo');

        Route::get('accept-terms', 'PreRegisterController@getAcceptTerms');
        Route::post('accept-terms', 'PreRegisterController@acceptTerms');

        Route::get('shipping_address', 'PreRegisterController@shippingAddressForm');
        Route::post('shipping_address', 'PreRegisterController@shippingAddress');
        Route::get('call-in', 'PreRegisterController@CallInForm');
		Route::post('find-sponsor', 'PreRegisterController@redirect');
		Route::resource('join', 'PreRegisterController', ['only' => ['create', 'store']]);
	});

	Route::group(array(), function() {
		Route::get('reports', 'ReportController@index');
		Route::get('api/report/sales/details/{id}', 'ReportController@saleDetails');
		Route::get('api/report/sales', 'ReportController@getReportSales');
		Route::get('api/report/inventory', 'ReportController@getReportInventory');

		if (Auth::check() && Auth::user() -> hasRole(['Superadmin', 'Admin'])) {
			Route::get('reports/{id}', 'ReportController@index');
		}
	});


	Route::get('populate-levels', function(){
		$level_count = Level::all()->count();
		DB::connection()->disableQueryLog();

		if ($level_count > 0) {
			return $level_count;
		} else {
			Commission::set_levels_down(0);
			return "Populated Levels";
		}

	});
});
##############################################################################################
# Replicated Site Routes
##############################################################################################

Route::group(array('domain' => '{subdomain}.'.\Config::get('site.base_domain'), 'before' => 'rep-site'), function($subdomain){
	// dd($subdomain);
	function ($subdomain){
		dd($subdomain);
	};

	# Make invoice payment
	Route::post('invoice/pay/{id}', 'InventoryController@payInvoice');
	Route::get('invoice/pay/{id}', 'InventoryController@showInvoice');
	Route::post('inv/purchase', 'InventoryController@purchase');

/*
		$title = 'Invoice Payment';
		$receipt = Receipt::find($id)->get();
		return View::make('inventory.payinvoice',compact($receipt));
*/

	Route::get('/', function($subdomain) {
		$user = User::where('public_id', $subdomain)->first();
		if ($user -> image == '')
			$user -> image = '/img/default-avatar.png';
		else
			$user -> image = '/img/users/avatars/' . $user -> image;
		$userSite = UserSite::firstOrNew(['user_id'=> $user->id]);
		$userSite->save();
		//return dd($userSite);
		if ((!isset($userSite -> banner)) || ($userSite -> banner == ''))
			$userSite -> banner = '/img/default-banner.jpg';
		else
			$userSite -> banner = '/img/users/banners/' . $userSite -> banner;
		$events = Uvent::where('public', 1)->where('date_start', '>', time())->take(5)->get();
		$opportunities = Opportunity::where('public', 1)->where('deadline', '>', time())->orWhere('deadline', '')->take(5)->orderBy('updated_at', 'DESC')->get();
		// echo '<pre>'; print_r($opportunities->toArray()); echo '</pre>';
		// exit;
		
		$addresses = [];
		// if (Address::where('addressable_id', $user->id)->where('label', 'Billing')->first() != NULL && ($user->hide_billing_address != true || Auth::user()->hasRole(['Superadmin', 'Admin']))) $addresses[] = Address::where('addressable_id', $user->id)->where('label', 'Billing')->first();
		if (Address::where('addressable_id', $user->id)->where('label', 'Shipping')->first() != NULL && ($user->hide_shipping_address != true || Auth::user()->hasRole(['Superadmin', 'Admin']))) $addresses[] = Address::where('addressable_id', $user->id)->where('label', 'Shipping')->first();
		
		return View::make('userSite.show', compact('user', 'userSite', 'opportunities', 'events', 'addresses'));
	});

	// opportunities (public view)
	Route::get('opportunity/{id}', function($subdomain, $id) {
		$opportunity = Opportunity::findOrFail($id);
		$sponsor = User::where('public_id', $subdomain)->first();
		return View::make('opportunity.public', compact('opportunity','sponsor'));
	});
	
	// event (public view)
	Route::get('public-events/{id}', function($subdomain, $id) {
		$event = Uvent::findOrFail($id);
		$sponsor = User::where('public_id', $subdomain)->first();
		$title = $event->name;
		return View::make('event.public_show', compact('event','title','sponsor'));
	});
	
	//timezone
	Route::post('set-timezone', 'TimezoneController@setTimezone');
	
});

##############################################################################################
# Testing and etc.
##############################################################################################

Route::get('test-steve', function() {
	phpinfo();
});

Route::get('clear-all-cache/{function}', function($function) {
	Cache::forget('route_'.Str::slug(action('DataOnlyController@' . $function)));
});

Route::get('test-cache/{id}', function($id) {
	$users = User::find($id)->descendants;
	//$result['users'] = $users;
	echo "<h1> Found ".$users->count()." descendants.</h1>";
	echo "<!-- <pre>";
	print_r($users -> toArray());
	echo "</pre> -->";
	$queries = DB::getQueryLog();
	echo "<pre>";
	print_r($queries);
	echo "</pre>";
	//return $result;
	return;
});

Route::get('test', function() {
	$start = microtime (true);
	$response['result'] = $rep = User::find(2001);
	//$response['result'] = User::find($rep_id)->clearUserCache();
	//$response['queries'] = Session::get('queries');
	//$response['queries'] = DB::getQueryLog();;
	//$response['result_cache_clear'] = $rep->clearUserCache();
	//$id = 2001;
	//return (Cache::has('user_'.$id.'_descendants'))?Cache::get('user_'.$id.'_descendants'):User::find($id)->descendants;
	//$response['result'] = User::find(2001)->plans;
	//$response['result'] = Commission::free_service(2001);
	$response['lapsed'] = round((microtime (true) - $start),5);
	return $response;
	exit;
	return User::take(150)->remember(1,'first125')->get();

	$start = microtime (true);
	$response['result'] = Commission::infinity(2024);
	//$response['result'] = User::find(2024)->ancestors()->whereNotNull('users.sponsor_id')->get();
	$response['lapsed'] = round((microtime (true) - $start),5);
	return $response;

	##############################################################################################
	# loading commission non-statically
	##############################################################################################
	
	$commission = new \LLR\Commission\Commission;
	$commission->setCommissionPeriod(date('Y-m-d',strtotime('last month')));
	$response['result'] = $commission->setRank(2001,true);
	$response['lapsed'] = round((microtime (true) - $start),5);
	return Response::json($response);
	return User::find(2001);
});

Route::get('test', function() {
	return App::environment();
});
/*
function addOrder($order, $key = 'orderdata') {
	$c = Session::get($key);
	$c[] = $order;
	Session::put($key, $c);
	return Session::save();
}
*/

Route::get('testfunction', function() {
$cart = stripslashes('[{\"model\":\"Irma\",\"size\":\"XXS\",\"numOrder\":3,\"price\":14,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Irma.jpg\"},{\"model\":\"Irma\",\"size\":\"XS\",\"numOrder\":3,\"price\":14,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Irma.jpg\"},{\"model\":\"Irma\",\"size\":\"S\",\"numOrder\":3,\"price\":14,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Irma.jpg\"},{\"model\":\"Julia\",\"size\":\"XXS\",\"numOrder\":3,\"price\":17,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Julia.jpg\"},{\"model\":\"Julia\",\"size\":\"XS\",\"numOrder\":3,\"price\":17,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Julia.jpg\"},{\"model\":\"Julia\",\"size\":\"S\",\"numOrder\":3,\"price\":17,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Julia.jpg\"},{\"model\":\"Julia\",\"size\":\"M\",\"numOrder\":3,\"price\":17,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Julia.jpg\"},{\"model\":\"Julia\",\"size\":\"L\",\"numOrder\":3,\"price\":17,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Julia.jpg\"},{\"model\":\"Lola\",\"size\":\"XXS\",\"numOrder\":3,\"price\":20,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Lola.jpg\"},{\"model\":\"Lola\",\"size\":\"XS\",\"numOrder\":3,\"price\":20,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Lola.jpg\"},{\"model\":\"Lola\",\"size\":\"S\",\"numOrder\":3,\"price\":20,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Lola.jpg\"},{\"model\":\"Lola\",\"size\":\"M\",\"numOrder\":3,\"price\":20,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Lola.jpg\"},{\"model\":\"Lola\",\"size\":\"L\",\"numOrder\":3,\"price\":20,\"image\":\"https:\\\/\\\/mylularoe.com\\\/img\\\/media\\\/Lola.jpg\"}]');

	$od		= App::make('InventoryController')->fixOrderData(json_decode($cart,true));
	$user	= User::find(11950);
	App::make('InventoryController')->putOrderInMyInventory($user,$od);
          
/*
	$r = new Receipt();
	$r->to_email		= 'mfrederico@gmail.com';
	$r->to_firstname	= 'Matthew';
	$r->to_lastname		= 'Frederico';
	$r->tax				= 1.00;
	$r->subtotal		= 10.00;
	$r->date_paid		= 0;
	$r->user_id			= 11950;
	$rid = $r->save();

	print "<pre>";
	//return Receipt::find(1)->ledger;
*/

	#Session::put('repsale',false);
	#Session::put('paidout',12.0);
	#Session::put('tax','1.0');
	#Session::put('subtotal','11.0');
	#Session::put('orderdata',array());
	#Session::put('userbypass','11950');
	#App::make('InventoryController')->finalizePurchase(array(),array());

});

Route::get('test-orders', function() {
	$reps = User::all();
	foreach ($reps as $rep) {
		$order = new Order;
		foreach ($rep->plans as $plan) {
			if ($plan -> price > 0) {
				//Order::$timestamps = false;
				//foreach
				$order->user()->associate($rep);
				$order->save();
				//echo"<pre>"; print_r($order->toArray()); echo"</pre>";
			} else {
				//echo"<pre>"; print_r($plan->toArray()); echo"</pre>";
			}
		}
		
	}
	//return $reps;
	return User::find(2001)->payments;
});

//automatic deployment script
if(is_file(app_path().'/controllers/Server.php')){
	Route::get('deploy-beta',['as'=>'deploy', 'uses'=>'Server@deploy_beta']);
	Route::get('deploy-production',['as'=>'deploy', 'uses'=>'Server@deploy_production']);
}

Route::get('sendonboardmail/{id}', function($id) {
	print "<pre>";
	$user  = User::find($id);
	$user->remember_token	= null;
	$user->hasSignup		= 1;
	$user->verified			= 1;
	$user->save();

	$userid		= $user->id;
	$sponsorid	= $user->sponsor_id;
	$dob		= $user->dob;

	// needs to be regular user id
	$public_id	= $user->id;
	$email		=  $user->email;

	$sponsor = User::where('id',$sponsorid)->first();
	Session::put('sponsor',$sponsor);

	$hash = sha1(sha1($userid).sha1($dob).sha1($sponsorid));
	$verification_link = 'http://'.Config::get('site.domain').'/u/'.$public_id.'-'.$hash;

	print "Sending ..";
	Mail::send('emails.verification', compact('verification_link', 'user'), function($message) use (&$user) {
		$message->to($user->email, $user->first_name.' '.$user->last_name)->subject('Please complete your '.Config::Get('site.company_name').' registration');
	});

	die('Sent!');
});
