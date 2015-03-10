<?php
    return [
            'domain' => 'llr-launch.controlpad.main',
            'contact_email' => 'randyb@zylun.com',
			'mwl_api'       => 'http://mwl.controlpad.com:8080/cms/',
			'mwl_db'        => 'llr',
			'admin_uid'     => 10095,
            'contact_first_name' => 'Matt',
            'contact_last_name'  => 'Frederico',
            'base_domain' => 'llr-launch.controlpad.main',
            'company_logo' => '/img/llr-logo.jpg',
            'preregistration_fee' => 2000.00,
            'new_time_frame' => 86400, // 1 day, /*604800*/ // 1 week
            'default_from_email' => 'no-reply@mylularoe.com',
            'company_name' => 'LulaRoe - Staging',
            //'subdomain' => Route::getCurrentRoute()->getParameter('subdomain'),
            'locked_subdomains' => [
                    'www'
            ],
            'cache_length' => 10
    ];

