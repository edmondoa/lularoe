<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Site general configutaion
	|--------------------------------------------------------------------------
	|
	| This file is for storage of settings for site

	|
	*/

	 'domain' => 'llr.dev',
	 'base_domain' => 'llr.dev',
	 'preregistration_fee' => 100.00,
	 'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
	 'default_from_email' => 'no-reply@lularoe.com',
	 'company_name' => 'LuLaRoe (local)',
	 //'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
	 'locked_subdomains' => [
	  'my',
	  'beta',
	  'lularoe',
	  'www',
	 ]
];