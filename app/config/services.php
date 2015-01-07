<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
<<<<<<< HEAD
		'domain' => 'sandboxa147995b44cf4930bda9ebdc01b306da.mailgun.org',
		'secret' => 'key-7jqfacss4emn2o2jrtyc8mbm1t-nc6v5',
=======
		'domain' => 'sociallymobile.com',
		'secret' => 'key-3a8c594730e4a044712e2a05ae8df3f3',
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
	),

	'mandrill' => array(
		'secret' => '',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

);
