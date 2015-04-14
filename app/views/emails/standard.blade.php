@extends('emails.layouts.basic')

@section('body')
	<img src="{{ $message->embed('img/email/purchase-header.jpg') }}" style="width:100%;">

	<h3>{{$user['first_name']}} {{$user['last_name']}}</h3>
	@if (!empty($shipinfo)) 
	<fieldset>
		<legend>{{ $shipinfo->label }}</legend>
			<table>
				<tr><td>{{ $shipinfo->address_1 }}</td></tr>
                <tr><td>{{ $shipinfo->address_2 }}</td></tr>
                <tr><td>{{ $shipinfo->city }}, {{ $shipinfo->state }}</td></tr>
                <tr><td>{{ $shipinfo->zip }}</td></tr>
            </table>
	</fieldset>
	@endif
	{{ $body}}
@stop

@section('footer')
	@parent
@stop
