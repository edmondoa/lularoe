<?php
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

					'mysql-mwl' => array(
						'driver'    => 'mysql',
						'host'      => 'localhost',
						'database'  => 'llr',
						'username'  => 'authUser',
                        'password'  => 'C0ntr01p@d',
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

