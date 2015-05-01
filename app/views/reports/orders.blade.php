@extends('layouts.default')
@section('content')
<div class="index">
	<h1>Orders Report</h1>
	<div ng-controller="ReportsController" class="my-controller">
        {{ Form::open(array('url' => 'levels')) }}
        <div class="pull-left form-group">
            {{ Form::select('view', [
                'ytd' => 'Year-To-Date',
                'monthly' => 'Monthly',
                'weekly' => 'Weekly',
                'daily' => 'Daily'
            ], 'monthly', ['id'=>'view_selector','class' => 'selectpicker']) }}
            
        </div>
        <div id="select_month" class="pull-right form-group">
            {{ Form::label('month', 'Select Month') }}
            {{ Form::select('month', $ytd, date('Y-m-d'), ['class' => 'selectpicker']) }}
        </div>
        <div id="select_date" class="pull-right form-group" style="display:none;">
            {{ Form::label('day', 'Select Date') }}
            {{ Form::text('day', null, ['ng-model'=>'day','class' => 'selectpicker dateonlypicker2']) }}
        </div>
        <div class="row">
            <div id="container" class="col-sm-11" ></div>
        </div>
		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="nav active"><a href="#received" role="tab" data-toggle="tab">Received</a></li>
				<!-- <li role="presentation" class="nav"><a href="#shipped" role="tab" data-toggle="tab">Shipped</a></li> -->
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="well tab-pane fade col col-md-12" id="shipped">
					<h3>Invoces - Shipped</h3>
				</div>

				 <div role="tabpanel" class="well tab-pane fade in active col col-md-12" id="received">
					<h3>Invoces - Received</h3>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">#</th>
                                <th>User ID</th>
                                <th>Date</th>
                                <th>Num</th><th>Person</th><th>Amount</th><th>Items</th>
							</tr>
						</thead>
						<tbody>
                        <?php $i=0;?>
							@foreach ($orderlist as $receipt) 
                            <?php $i++; ?>
							<tr class="media">
                                <td>{{$i}}</td>
                                <td>{{$receipt->user_id}}</td>
                                <!--<td><pre>{{print_r($receipt)}}></pre></td>-->
								<td><div>{{$receipt->created_at}}</div></td>
								<td><div>{{$receipt->id}}</div></td>
								<td><div>@if ($receipt->to_firstname != 'n/a' && $receipt->to_lastname != 'n/a'){{$receipt->to_firstname}} {{$receipt->to_lastname}} @endif {{$receipt->to_email}}</div></td>
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
        {{Form::close()}}
	</div>
</div><!-- app -->
@stop
@section('scripts')
<script>
    angular.extend(ControlPad, (function(){                
                return {
                    reportsCtrl : {
                        title : 'Orders Received',
                        ytitle : 'Number of Transactions',
                        path: '/api/getMetrics/'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/reportsController.js') }}
{{ HTML::script('bower_components/highcharts-release/highcharts.js') }}
{{ HTML::script('js/displaychart.js') }}
@stop
