<?php
if (isset($_SERVER['HTTP_HOST']) && preg_match('/mylularoe.local$/', $_SERVER['HTTP_HOST']))
{
	return [
			'domain' => 'mylularoe.local',
			'contact_email' => 'mfrederico@gmail.com',
			'admin_uid'		=> 10095,
			'contact_first_name' => 'Matt',
			'contact_last_name'  => 'Frederico',
			'base_domain' => 'www.mylularoe.local',
			'company_logo' => '/img/llr-logo.png',
			'preregistration_fee' => 2000.00,
			'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
			'default_from_email' => 'no-reply@mylularoe.com',
			'company_name' => 'LulaRoe - Dev',
			//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
			'locked_subdomains' => [
					'www'
			],
			'cache_length' => 10
	];
}
elseif (isset($_SERVER['HTTP_HOST']) && preg_match('/mylularoe.com$/', $_SERVER['HTTP_HOST']))
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
			'admin_uid'		=> 10095,
			'contact_first_name' => 'Matt',
			'contact_last_name'  => 'Frederico',
			'base_domain' => 'www.mylularoe.com',
			'company_logo' => '/img/llr-logo.png',
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
elseif (isset($_SERVER['HTTP_HOST']) && preg_match('/llr.controlpad.zylun$/', $_SERVER['HTTP_HOST']))
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

            'domain' => 'llr.controlpad.zylun',
            'contact_email' => 'mfrederico@gmail.com',
            'admin_uid'        => 10095,
            'contact_first_name' => 'Matt',
            'contact_last_name'  => 'Frederico',
            'base_domain' => 'llr.controlpad.zylun',
            'company_logo' => '/img/llr-logo.png',
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
elseif (isset($_SERVER['HTTP_HOST']) && preg_match('/intranet.zylun.local$/', $_SERVER['HTTP_HOST']))
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

            'domain' => 'intranet.zylun.local',
            'contact_email' => 'mfrederico@gmail.com',
            'admin_uid'        => 10095,
            'contact_first_name' => 'Matt',
            'contact_last_name'  => 'Frederico',
            'base_domain' => 'intranet.zylun.local',
            'company_logo' => '/img/llr-logo.png',
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

		'domain' 		=> 'my.llr.controlpad.com',
		'mwl_api'		=> 'http://mwl.controlpad.com:8080/cms/',
		'mwl_db'		=> 'llr',
		'admin_uid'		=> 10095,
		'base_domain' => 'llr.controlpad.com',
		'preregistration_fee' => 100.00,
		'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
		'default_from_email' => 'no-reply@mylularoe.com',
		'contact_email' => 'mfrederico@gmail.com',
		'contact_first_name' => 'Matt',
		'contact_last_name'  => 'Frederico',
		'company_name' => 'LulaRoe - Staging',
		//'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
		'locked_subdomains' => [
			'my',
			'www',
			'llr'
		],
		'cache_length' => 10
	];
}
