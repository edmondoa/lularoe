@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Transaction Details</h1>
		<div class="col col-md-6 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 div class="panel-title">Information:</h2>
				</div>
				<table class="table table-striped">
					<tr>
						<th>
							Customer:
						</th>
						<td>{{ $transaction->customer or ''}}</td>
					</tr>
					<tr>
						<th>
							Amount:
						</th>
						<td>
							{{ "$".number_format($transaction->amount,2) }}
						</td>
					</tr>
					<tr>
						<th>
							Tax:
						</th>
						<td>
							{{ "$".number_format($transaction->salesTax,2) }}
						</td>
					</tr>
					<tr>
						<th>
							Status:
						</th>
						<td>
							{{ $transaction->status or ''}}
						</td>
					</tr>
					<tr>
						<th>
							Type:
						</th>
						<td>
							{{ $transaction->type or '' }}
						</td>
					</tr>
					<tr>
						<th>
							Processed:
						</th>
						<td>
							{{ $transaction->collected or '' }}
						</td>
					</tr>
					<tr>
						<th>
							Date:
						</th>
						<td>
							{{ date('M j, Y',strtotime($transaction->transaction_date)) }}
						</td>
					</tr>
				</table>
			</div><!-- panel -->
		</div><!-- col -->
	</div><!-- tabpanel -->
	<br style="clear:both" />
@stop
