@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Payments to {{$consultant->first_name}} {{$consultant->last_name}}</h1>
	<div class="my-controller">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th><th class="header">Date</th><th>Amount</th><th>Processing</th><th>Sales Tax</th><th></th>
					</tr>
				</thead>
				<tbody>
						@foreach($payments as $payment)
							<tr>
							<?php 
								//echo"<pre>"; print_r($payment); echo"</pre>"; 
								//continue;
							?>
								<td>
									<a href="{{URL::action('ReportController@ReportPaymentsDetails',$payment->id)}}">Details</a>
								</td>
								<td>
									{{$payment->created_at or ''}}
								</td>
								<td><span class="text-left">$</span><span class="text-right">{{ number_format($payment->amount,2)}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{$payment->fees['Processing_Fees'] or ''}}</span></td>
								<td><span class="text-left">$</span><span class="text-right">{{$payment->fees['Sales_Tax'] or ''}}</span></td>
								<td></td>
								<td></td>
								@if((isset($payment->transactions))&&(is_array($payment->transactions)))
								<?php 
									$total = 0;
								?>
								</tr><tr>
								<td colspan="5">
									<table class="table table-striped table-hover">
										@foreach($payment->transactions as $transaction)
											<tr>
												<td>{{$transaction->txtype or ''}}</td>
												<td>{{$transaction->refNum or ''}}</td>
												<td>{{date('m/d/Y',strtotime($transaction->created_at))}}</td>
												<td>{{ucwords($transaction->customer)}}</td>
												<td class="text-right">${{$transaction->authAmount or ''}}</td>
												{{-- <td class="text-right">${{$transaction->paid or ''}}</td></tr> --}}
											</tr>
											<?php 
												$total += $transaction->authAmount;
											?>
										@endforeach
										<tr><td><strong>Sales Total</strong></td><td class="text-right"><strong>${{$total or ''}}</strong></td>
									</table>
								</td>
								<td></td>
								</tr>
								@endif
							</tr>
						@endforeach
				</tbody>
			</table>
	</div><!-- tabpanel -->

</div><!-- app -->
@stop
