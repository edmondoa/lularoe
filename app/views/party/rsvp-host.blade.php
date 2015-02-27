@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row page-actions">
		<h1 class="no-top">
			@if ($status == 'attend')
				Thank You for Choosing to Host this Party
			@else
				Thank You for Your Response
			@endif
		</h1>
		<div class="alert alert-success">
			@if ($status == 'attend')
				{{ $party->organizer_name }} has been notified that you'll be hosting.
			@else
				The organizer and host have been notified that you'll not be hosting this party.
			@endif
		</div>
		@if ($status == 'attend')
			<table class="table table-striped">
				<tr>
					<th style="width:0;">Event:</th>
					<td>{{ $party->name }}</td>
				</tr>
				<tr>
					<th>Date:</th>
					<td>{{ date('l, F jS, g:i a', $party->date_start) }} - {{ date('g:i a', $party->date_end) }}</td>
				</tr>
		        <tr>
		        	<th>Organizer:</th>
		        	<td>
		        		{{ $party->organizer_name }}<br>
		        		{{ $organizer->formatted_phone }}<br>
		        		{{ $organizer->email }}
		        	</td>
		        </tr>
		        <tr>
		        	<th>Host:</th>
		        	<td>{{ $party->host_name }}</td>
		        </tr>
				@if (isset($address))
					<tr>
						<th>Location:</th>
						<td>
						    <table>
						    	@if (isset($address->label))
							        <tr>
							            <td>{{ $address->label }}</td>
							        </tr>
							    @endif
						        <tr>
						            <td>{{ $address->address_1 }}</td>
						        </tr>
						        
						        @if (!empty($address->address_2))
							        <tr>
							            <td>{{ $address->address_2 }}</td>
							        </tr>
						        @endif
						        <tr>
						            <td>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</td>
						        </tr>
						    </table>
						</td>
					</tr>
				@endif
			</table>
		@endif
	</div>
</div>
@stop
