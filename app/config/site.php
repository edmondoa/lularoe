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

	'domain' => 'my.llr.controlpad.com',
	'base_domain' => 'llr.controlpad.com',
	'preregistration_fee' => 100.00,
	'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
	'default_from_email' => 'no-reply@llrdev.com',
	'company_name' => 'LLRDEV',
	//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
	'locked_subdomains' => [
		'my',
		'beta',
		'www',
		'llr',
	]
];
	],
	'cache_length' => 10
];
