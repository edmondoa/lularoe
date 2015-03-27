@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
	<h1>Reports</h1>
	<div ng-controller="ReportsController" class="my-controller">

		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="nav active"><a href="#sales" role="tab" data-toggle="tab">Sales</a></li>
				<li role="presentation" class="nav"><a href="#inventory" role="tab" data-toggle="tab">Inventory</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="well tab-pane fade col col-md-12" id="inventory">
					<h3>Not implemented .. yet </h3>
				</div>

				 <div role="tabpanel" class="well tab-pane fade in active col col-md-12" id="sales">
					<h3>Sales</h3>
					<table ng-model='reportSales' class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">Date</th><th>Num</th><th>Person</th><th>Amount</th><th>Items</th>
							</tr>
						</thead>
						<tbody>
							<tr class="media" ng-repeat="txn in reportSales">
								<td><div ng-bind="txn.date"></div></td>
								<td><div ng-bind="txn.order_number"></div></td>
								<td><div ng-bind="txn.account"></div></td>
								<td>
									<span ng-show="txn.is_cash"><i class="fa fa-money pull-right" style="color:green"></i></span>
									<span ng-hide="txn.is_cash"><i class="fa fa-credit-card pull-right"></i></span>
									<div ng-bind="txn.amount"></div></td>
								<td><ul ng-repeat="item in txn.items"><li><span ng-bind="item.price"></span></li></ul></div></td>
							</tr>
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
    angular.extend(ControlPad, (function(){                
                return {
                    reportSalesCtrl : {
                        path : '/api/report/sales/'
                    },
                    reportInventoryCtrl : {
                        path : '/api/report/inventory/'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/reportsController.js') }}
@stop
