@extends('emails.layouts.default')
@section('body')
	<p>Dear {{ $user['first_name'] }},</p>
	<p>I'd like to invite you to host my {{ Config::get('site.company_name') }} party on {{ date('l, F jS', $party->date_start) }}.</p>
	<table cellpadding="10" class="table table-striped">
		<tr style="background:rgb(240,240,240);">
			<th style="text-align:right; vertical-align:top;">Event:</th>
			<td>{{ $party->name }}</td>
		</tr>
		<tr>
			<th style="text-align:right; vertical-align:top;">Date:</th>
			<td>{{ date('l, F jS, g:i a', $party->date_start) }} - {{ date('g:i a', $party->date_end) }}</td>
		</tr>
		@if (isset($address))
			<tr style="background:rgb(240,240,240);">
				<th style="text-align:right; vertical-align:top;">Location:</th>
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
	<p id="additional-notes">{{ $body }}</p>
	<p>To learn more, you can call me at {{ Auth::user()->formatted_phone }}, respond to this email, or check out my store at: <a target="_blank" href="http://{{ Auth::user()->public_id }}.{{ Config::get('site.base_domain') }}">http://{{ Auth::user()->public_id }}.{{ Config::get('site.base_domain') }}</a>.</p>
	<h2>Would you like to host this party?</h2>
	<p>
		<a style="padding:10px 20px; background:#EB0F8B; color:white; text-decoration:none; display:inline-block;" href="http://{{ Config::get('site.domain') }}/host-rsvp/{{ $party->id }}/{{ $user['id'] }}/Lead/attend" class="btn btn-primary" type="button">Yes</a> <a style="padding:10px 20px; background:#EB0F8B; color:white; text-decoration:none; display:inline-block;" href="http://{{ Config::get('site.domain') }}/host-rsvp/{{ $party->id }}/{{ $user['id'] }}/Lead/decline" class="btn btn-primary" type="button">No</a>
	</p>
@stop

@section('footer')
	@parent
@stop