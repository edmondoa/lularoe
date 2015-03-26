@extends('emails.layouts.basic')

@section('body')
<body style="width:100%" width="100%">
<h1>New Invoice Order</h1>
<h3>{{$user['first_name']}} {{$user['last_name']}}</h3>
<img src="{{ $message->embed('img/email/order-header.jpg') }}" style="width:100%;">

<font size="+1">
	{{ $body}}
</font>
</body>
@stop

@section('footer')
	@parent
@stop
