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

		'domain' 		=> 'www.mylularoe.com',
		'mwl_api'		=> 'http://mwl.controlpad.com:8080/cms/',
		'mwl_db'		=> 'llr',
		'admin_uid'		=> 10095,
		'base_domain' 	=> 'mylularoe.com',
		'preregistration_fee' => 2000.00,
		'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week

		'company_logo' => '/img/llr-logo.png',
		'company_logo_minimal' => '/img/llr-logo-minimal.png',
		'preregistration_fee' => 2000.00,

		'default_from_email' => 'no-reply@mylularoe.com',
		'contact_email' => 'mfrederico@gmail.com',
		'contact_first_name' => 'Matt',
		'contact_last_name'  => 'Frederico',
		'company_name' => 'LulaRoe',
		//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
		'locked_subdomains' => [
			'my',
			'www',
			'llr'
		],
		'cache_length' => 10
	];
