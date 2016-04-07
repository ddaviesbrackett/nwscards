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
		'domain' => 'mg.nelsonwaldorf.org',
		'secret' => 'key-d3555d79a7d8bdf98264377800e60696',
	),

	'mandrill' => array(
		'secret' => $_ENV['mandrill_key'],
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => $_ENV['stripe_secret_key'],
	),

);
