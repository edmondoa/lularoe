<?php

if (preg_match('/mylularoe.com/',$_SERVER['HTTP_HOST']))
{
	return [

			/*
			|--------------------------------------------------------------------------
			| Site general configutaion
			|--------------------------------------------------------------------------
			|
			| This file is for storage of settings for site

			|
			*/

			'domain' => 'www.mylularoe.com',
			'contact_email' => 'mfrederico@gmail.com',
			'contact_first_name' => 'Matt',
			'contact_last_name'  => 'Frederico',
			'base_domain' => 'www.mylularoe.com',
			'preregistration_fee' => 2000.00,
			'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
			'default_from_email' => 'no-reply@mylularoe.com',
			'company_name' => 'LulaRoe',
			//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
			'locked_subdomains' => [
					'www'
			],
			'cache_length' => 10
	];
}
else 
{
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
		'default_from_email' => 'no-reply@mylularoe.com',
		'contact_email' => 'mfrederico@gmail.com',
		'contact_first_name' => 'Matt',
		'contact_last_name'  => 'Frederico',
		'company_name' => 'LLRDEV',
		//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
		'locked_subdomains' => [
			'my',
			'beta',
			'www',
			'llr'
		],
		'cache_length' => 10
	];
}

