@extends('layouts.default')
@section('content')
<div class="index">
	<h1>Reports</h1>
	<div class="my-controller">

		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="nav active"><a href="#received" role="tab" data-toggle="tab">Received</a></li>
				<li role="presentation" class="nav"><a href="#shipped" role="tab" data-toggle="tab">Shipped</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="well tab-pane fade col col-md-12" id="shipped">
					<h3>Orders - Shipped</h3>
				</div>

				 <div role="tabpanel" class="well tab-pane fade in active col col-md-12" id="received">
					<h3>Orders - Received</h3>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">Date</th><th>Num</th><th>Person</th><th>Amount</th><th>Items</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orderlist as $receipt) 
							<tr class="media">
								<td><div>{{$receipt->created_at}}</div></td>
								<td><div>{{$receipt->id}}</div></td>
								<td><div>{{$receipt->to_firstname}} {{$receipt->to_lastname}}</div></td>
								<td>
									@if ($receipt->tax > 0) <div>{{$receipt->tax}}</div> @endif
									<div>{{$receipt->subtotal}}</div>
								</td>
								<td>
										<a href="/invoice/view/{{$receipt->id}}" TARGET="_BLANK" class="btn btn-smi btn-default">Show Invoice</a>
								</td>
							</tr>
							<tr>
								<td colspan="100">{{$receipt->note}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div><!-- tabcontent -->
		</div><!-- tabpanel -->
	</div>
</div><!-- app -->
@stop
@section('scripts')
@stop
