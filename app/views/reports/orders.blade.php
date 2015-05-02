@extends('layouts.default')
@section('content')

<div class="index">
	<h1>Receipts and Invoices</h1>
	<div class="my-controller">

		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="nav active"><a href="#received" role="tab" data-toggle="tab">Received</a></li>
				<li role="presentation" class="nav"><a href="#shipped" role="tab" data-toggle="tab">Shipped</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="well tab-pane fade col col-md-12" id="shipped">
					<h3>Orders - Shipped</h3>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">Date Shipped</th><th>Num</th><th>Person</th><th>Tax</th><th>Subtotal</th><th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orderlist as $receipt) 
							@if ($receipt->shipped != '0000-00-00 00:00:00')
							<tr class="media">
									
								<td>
									@if ($receipt->printed != '0000-00-00 00:00:00') <a href="#" data-toggle="tooltip" class="pull-left fa fa-print" title="{{$receipt->printed}}"></a> @endif
								<div>{{$receipt->shipped}}</div></td>
								<td><div>{{$receipt->id}}</div></td>
								<td><div>{{$receipt->to_firstname}} {{$receipt->to_lastname}}</div></td>
								<td><div>{{$receipt->tax}}</div></td>
								<td><div>{{$receipt->subtotal}}</div></td>
								<td><a href="/invoice/view/{{$receipt->id}}" TARGET="_BLANK" class="btn btn-sm btn-default">View</a></td>
							</tr>
							<tr>
								<td colspan="100">{{$receipt->note}}</td>
							</tr>
							@endif 
							@endforeach
						</tbody>
					</table>
				</div>

				 <div role="tabpanel" class="well tab-pane fade in active col col-md-12" id="received">
					<h3>Orders - Received</h3>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">Date</th><th>Num</th><th>Person</th><th>Tax</th><th>Subtotal</th><th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orderlist as $receipt) 
							@if ($receipt->shipped == '0000-00-00 00:00:00')
							<tr class="media">
								<td>
									@if ($receipt->printed != '0000-00-00 00:00:00') <a href="#" data-toggle="tooltip" class="pull-left fa fa-print" title="Printed: {{$receipt->printed}}"></a> @endif
									<div>{{$receipt->created_at}}</div></td>
								<td><div>{{$receipt->id}}</div></td>
								<td><div>{{$receipt->to_firstname}} {{$receipt->to_lastname}}</div></td>
								<td><div>{{$receipt->tax}}</div>
								<td><div>{{$receipt->subtotal}}</div></td>
								<td>
									<a href="/invoice/view/{{$receipt->id}}" TARGET="_BLANK" class="btn btn-smi btn-default">View</a>
								</td>
							</tr>
							<tr>
								<td colspan="100">{{$receipt->note}}</td>
							</tr>
							@endif 
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
    });
});
</script>
@stop
