@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Transactions in Payment</h1>
	<div class="my-controller">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th><th class="header">Date</th><th>Amount</th><th>Type</th><th>Status</th><th></th>
					</tr>
				</thead>
				<tbody>
						@foreach($transactions as $transaction)
							<tr>
								<td><a href="{{URL::action('ReportController@ReportTransactionDetails',$transaction->Id)}}">Details</a></td>
								<td>{{$transaction->Date or ''}}</td>
								<td class>{{ "$".number_format($transaction->Total,2) }}</td>
								<td>{{ucfirst($transaction->Type) or ''}}</td>
								<td>{{$transaction->State or ''}}</td>
								<td></td>
								<td></td>
							</tr>
						@endforeach
				</tbody>
			</table>
	</div><!-- tabpanel -->

</div><!-- app -->
@stop
