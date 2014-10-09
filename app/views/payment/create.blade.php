@extends('default')
@section('content')
{{Form::open(['action' => 'PaymentController@store'])}}
	
	<div class="form-group">
		{{ Form::label('name_on_card','* Name on Card') }}
		{{ Form::text('name_on_card',Auth::user()->first_name." ".Auth::user()->last_name) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('card_number','* Card Number') }}
		{{ Form::text('card_number') }}
	</div>

	<div class="form-group">
		{{ Form::label('expires_year','* Expires') }}
		<select name="expires_month" class="selectpicker">
			<?php
				for ($y = 1; $y <= 12; $y ++) {
					if ($y < 10) $y = "0" . $y;
					echo "<option>$y</option>";
				}
			?>
		</select>
		<select name="expires_year" class="selectpicker">
			<?php
				$y = date('Y');
				$x = $y + 10;
				for ($y = date('Y'); $y <= $x; $y ++) {
					echo "<option>$y</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		{{ Form::label('expires_year','* Security Code') }}
		{{ Form::text('security', null, array('style' => 'width:22px')) }}
	</div>

	<div class="form-group">
		{{ Form::label('refund_policy','* Refund Policy') }}
		{{ Form::checkbox('refund_policy') }}
	</div>
	
	<div class="form-group">
		<label for="refund_policy" style="font-size:10pt; !important; max-width:250px; display:inline-block; vertical-align:top;">
			I agree to the terms and conditions.
		</label>
	</div>

	{{ Form::submit('Pay Now!') }}
{{ Form::close() }}
@stop