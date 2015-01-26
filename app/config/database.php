<?php
/*****************************/
//* NOTICE:
/*****************************/
// Please create a preg_match for your database/domain settings 
// when developping on your local database
// Author: Matt Frederico

// Main site
if (preg_match('/mylularoe.com$/',$_SERVER['HTTP_HOST']))
{
	return array(

			'fetch' => PDO::FETCH_CLASS,
			'default' => 'mysql',
			'connections' => array(
					'mysql' => array(
							'driver'    => 'mysql',
							'host'      => 'mwl.controlpad.com',
							'database'  => 'llr_web',
							'username'  => 'llr_web',
							'password'  => '7U8$SAV*NEjuB$T%',
							'charset'   => 'utf8',
							'collation' => 'utf8_unicode_ci',
							'prefix'    => '',
					),

			),

			'migrations' => 'migrations',
			'redis' => array(

					'cluster' => false,

					'default' => array(
							'host'     => '127.0.0.1',
							'port'     => 6379,
							'database' => 0,
					),

			),

	);
}
// This is the default connection
else
{
	return array(
		'fetch' => PDO::FETCH_CLASS,
		'default' => 'mysql',
		'connections' => array(

			'mysql' => array(
				'driver'    => 'mysql',
				'host'      => 'localhost',
				'database'  => 'llr_dev',
				'username'  => 'llr_dev',
				'password'  => '7U8$SAV*NEjuB$T%',
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => '',
			),
		),

		'migrations' => 'migrations',
		'redis' => array(

			'cluster' => false,

			'default' => array(
				'host'     => '127.0.0.1',
				'port'     => 6379,
				'database' => 0,
			),

		),

	);
}
