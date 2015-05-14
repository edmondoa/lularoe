@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Payments to {{$consultant->first_name}} {{$consultant->last_name}}</h1>
	<div class="my-controller">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th><th class="header">Date</th><th>Amount</th><th></th><th></th><th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach($payments as $payment)
							<td><a href="{{URL::action('ReportController@ReportPaymentsDetails',$consultant->id)}}">Details</a></td><td>{{$payment->date or ''}}</td><td>{{$payment->Total or ''}}</td><td></td><td></td><td></td><td></td>
						@endforeach
					</tr>
				</tbody>
			</table>
	</div><!-- tabpanel -->

</div><!-- app -->
@stop
