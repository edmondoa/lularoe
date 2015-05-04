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

		'domain' 		=> 'beta.mylularoe.com',
		'mwl_api'		=> 'http://mwl-beta.controlpad.com:8080/cms/',
		'mwl_db'		=> 'llr',
		'mwl_username'	=> '0',
		'mwl_password'	=> 'controlpad1',
		'admin_uid'		=> 0,
		'base_domain' 	=> 'beta.mylularoe.com',
		'preregistration_fee' => 2000.00,
		'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week

		'customer_service'=>'951-737-7875',
		'company_logo' => '/img/llr-logo.jpg',
		'company_logo_minimal' => '/img/llr-logo-minimal.png',
		'preregistration_fee' => 2000.00,

		'default_from_email' => 'no-reply@mylularoe.com',
		'contact_email' => 'info@lularoe.com',
		'warehouse_email' => 'orders@lularoe.com',
		'contact_first_name' => 'Support',
		'contact_last_name'  => 'LuLaRoe',
		'rep_title'			=> 'FC',
		'company_name' => 'LuLaRoe',
		//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
		'locked_subdomains' => [
			'my',
			'www',
			'llr'
		],
		'cache_length' => 10
	];
