@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Payments to {{$consultant->first_name}} {{$consultant->last_name}}</h1>
	<div class="my-controller">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th><th class="header">Date</th><th></th><th>Amount</th><th></th><th></th><th></th>
					</tr>
				</thead>
				<tbody>
						@foreach($payments as $payment)
							<tr>
							<?php 
								//echo"<pre>"; print_r($payment); echo"</pre>"; 
								//continue;
							?>
								<td><a href="{{URL::action('ReportController@ReportPaymentsDetails',$payment->id)}}">Details</a></td><td>{{$payment->created_at or ''}}</td><td>$</td><td class="text-right">${{ number_format($payment->amount,2)}}</td><td></td><td></td><td></td><td></td>
							</tr>
						@endforeach
				</tbody>
			</table>
	</div><!-- tabpanel -->

</div><!-- app -->
@stop
