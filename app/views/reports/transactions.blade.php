@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Sales for {{$consultant->first_name}} {{$consultant->last_name}}</h1>
	<div class="my-controller">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th><th class="header">Date</th><th>Cash Amount</th><th>Cash Tax</th><th>Card Amount</th><th>Card Tax</th><th>Sub-Total</th><th>Tax Total</th><th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
						@foreach($transactions as $transaction)
							<tr>
							<?php 
								//echo"<pre>"; print_r($transaction); echo"</pre>"; 
								//continue;
							?>
								<td>
									{{-- <a href="{{URL::action('ReportController@ReportPaymentsDetails',$transaction->id)}}">Details</a> --}}
								</td>
								<td>
									{{ date('m/d/Y',strtotime($transaction->created_at))}}
								</td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->CASH,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->TAX_CASH,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->CARD,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->TAX_CARD,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->SUBTOTAL,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->TAX_TOTAL,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($transaction->TOTAL,2)}}</span></td>
							</tr>
						@endforeach
				</tbody>
			</table>
	</div><!-- tabpanel -->

</div><!-- app -->
@stop
