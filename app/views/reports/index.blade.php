@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
	<h1>Reports</h1>
	<div ng-controller="ReportsController" class="my-controller">

		 <div class="col col-md-6">
		 <h3>Sales</h3>
		<table ng-model='reportSales' class="table table-striped">
			<tr>
				<th>Date</th><th>Person</th><th>Amount</th><th>Items</th>
			</tr>
			<tr class="media" ng-repeat="txn in reportSales">
				<td><div ng-bind="txn.date"></div></td>
				<td><div ng-bind="txn.account"></div></td>
				<td><div ng-bind="txn.amount"></div></td>
				<td><ul ng-repeat="item in txn.items"><li><span ng-bind="item.price"></span></li></ul></div></td>
			</tr>

		</table>
		</div>
		 <div class="col col-md-6">Inventory</div>
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
