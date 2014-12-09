@extends('emails.layouts.basic')
@section('body')
<p>
	<strong>Name:</strong><?php echo($data['name']); ?><br>
	<strong>Email:</strong><?php echo($data['email']); ?><br>
	<strong>Subject:</strong><?php echo($data['subject_line']); ?>
</p>
<p>
	<strong>Message:</strong>
	<br>
	<?php echo($data['body']); ?>
</p>
<p>
	<strong>Date:</strong><?php echo date("F j, Y, g:i a"); ?>
	<strong>User IP address:</strong><?php echo Request::getClientIp(); ?>
</p>
<img src="/img/socially-mobile-logo.png" alt="{{ Config::get('site.company_name') }}">
@stop
@section('unsubscribe')
@stop