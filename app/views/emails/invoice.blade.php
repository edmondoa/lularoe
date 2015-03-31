@extends('emails.layouts.basic')
<?php $shipinfo = $user->addresses->filter(function($d) { return $d->label == 'Shipping'; })->first(); ?>

@section('body')
<body style="width:100%" width="100%">
<h1>New Invoice Order</h1>

<h2>Shipping Information</h2>
<font size="+1">
	<table style="width:100%" width="100%">
		<tr><td>{{$user['first_name']}} {{$user['last_name']}}</td></tr>
		<tr><td>{{ $shipinfo->address_1 }}</td></tr>
		<tr><td>{{ $shipinfo->address_2 }}</td></tr>
		<tr><td>{{ $shipinfo->city }}</td></tr>
		<tr><td>{{ $shipinfo->state }}</td></tr>
		<tr><td>{{ $shipinfo->zip }}</td></tr>
	</table>
</font>
<h2>Shipping Manifest</h2>
<font size="+1">

		{{ $body}}
	</font>
</body>
@stop

@section('footer')
	@parent
@stop
