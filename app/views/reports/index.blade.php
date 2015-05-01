@extends('layouts.default')
@section('style')
<style>
.tab-content >.active {
      border-right: 1px solid #ddd;
      border-left: 1px solid #ddd;
      border-bottom: 1px solid #ddd;
}
.collapse-custom .navbar-tool {
  display: none;
}
.collapse-custom .navbar {
  margin-bottom: 0;
  border-radius: 0;
  cursor: pointer;
  border-bottom: none;
}
.collapse-custom .navbar .btn-xs {
  font-size: inherit;
}
.collapse-custom .navbar li ul {
  list-style-type: none;
  padding-left: 15px;
}
/*
.collapse-custom .navbar:last-of-type {
  border-bottom: 1px solid #e7e7e7;
}*/
.collapse-custom .navbar-heading {
  background-color: #3276b1;
  cursor: default;
  font-weight: bold;
  font-size: 16px;
}
.collapse-custom .navbar-heading li {
  padding: 10px 0 10px 0;
}
.collapse-custom .navbar-heading li a {
  color: #fff;
}
.collapse-custom .navbar-heading li a:hover {
  color: #fff;
}

.collapse-custom .navbar-nav li a{
    color:#333;
}
.collapse-custom .navbar-nav li a:hover{
    color:#000;
}

.collapse-custom .navbar-nav .one {
  min-width: 120px;
}
.collapse-custom .navbar-nav .two {
  min-width: 300px;
}
.collapse-custom .navbar-nav .three {
  min-width: 75px;
}
.collapse-custom .navbar-nav .four {
  min-width: 110px;
}
.collapse-custom .navbar-nav .five {
  width: 20px;
}
.collapse-custom .collapse {
  background-color: #fff;
}
.collapse-custom .collapsed {
  background-color: #fff !important;
}
.collapse-custom .collapse-open {
  background-color: #f5f5f5;
}
</style>
@stop
@section('content')
<div ng-app="app" class="index">
	<h1>Sales Report</h1>
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
            {{ Form::select('month', $ytd, 0 , ['ng-model'=>'month','id'=>'month_selector','class' => 'selectpicker']) }}
        </div>
        <div id="select_date" class="pull-right form-group" style="display:none;">
            {{ Form::label('day', 'Select Date') }}
            {{ Form::text('day', null, ['ng-model'=>'day','id'=>'day_selector','class' => 'selectpicker dateonlypicker2']) }}
        </div>
        <div class="row">
            <div id="container" class="col-sm-11" ></div>
        </div>
		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="nav active"><a href="#sales" role="tab" data-toggle="tab">Sales</a></li>
				<li role="presentation" class="nav"><a href="#invoices" role="tab" data-toggle="tab">Invoices / Receipts</a></li>
				<li role="presentation" class="nav"><a href="#inventory" role="tab" data-toggle="tab">Inventory</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="panel-body tab-pane fade col col-md-12" id="invoices">
					<table ng-model='reportReceipts' class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="header">Id</th>
								<th>Date</th>
								<th>Person</th>
								<th>Amount</th>
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							<tr class="media" ng-repeat="rcpt in reportReceipts" ng-click="showReceiptDetails($index)">
								<td><$rcpt.id></td>
								<td><$rcpt.created_at></td>
								<td><$rcpt.to_firstname> <$rcpt.to_lastname></td>
								<td><$rcpt.subtotal></td>
								<td><span ng-if="rcpt.date_paid == '0000-00-00 00:00:00'" ng-then="ispaid">
										<span style="color:red"><$rcpt.balance></span>
									</span>
									<span ng-if="rcpt.date_paid != '0000-00-00 00:00:00'" ng-then="ispaid">
										<span style="color:green">PAID</span>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div role="tabpanel" class="tab-pane fade col col-md-12" id="inventory">
					<h3>Not implemented .. yet </h3>
				</div>

				 <div role="tabpanel" class="tab-pane fade in active col col-md-12" id="sales">
					<h3>Sales</h3>
                    

<div class="collapse-custom">

  <nav class="navbar navbar-default navbar-heading" role="navigation">
    <div class="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="two"><a>Date</a></li>
        <li class="two"><a>Amount</a></li>
        <li class="four"><a>Tax</a></li>
        <li class="five"><a>Items</a></li>
      </ul>
    </div>
  </nav>
  <div class="" ng-repeat="(index,entry) in reportSalesDates">
      <nav class="navbar navbar-default" role="navigation">
        <div ng-click="details(entry)" class="collapse navbar-collapse" id="bs-example-navbar-collapse-<$index>" data-toggle="collapse" href="#collapse<$index>">
          <ul class="nav navbar-nav">
            <li class="two"><a><$entry.date | date:'MMM dd, yyyy'></a></li>
            <li class="two"><a><$entry.amount | currency></a></li>
            <li class="four"><a><$entry.tax></a></li>
            <li class="five"><a><span class="badge"><$entry.items></span></a></li>
          </ul>
        </div>
      </nav>
      <div id="collapse<$index>" class="collapse" data-parent="bs-example-navbar-collapse-<$index>">
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="header">#</th><th>Date</th><th>Num</th><th>Person</th><th>Amount</th><th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="media" ng-repeat="(index,txn) in entry.details">
                        <td><div ng-bind="(index +1)"></div></td>
                        <td><div ng-bind="txn.created_at"></div></td>
                        <td><div ng-bind="txn.transactionid"></div></td>
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
      </div>
  </div>
  
</div>



<!--------------------end----------------->
                    
                    
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
    {{Form::close()}}
</div><!-- app -->
@stop
@section('scripts')
<script>
    angular.extend(ControlPad, (function(){                
                return {
                    reportsCtrl : {
                        title : 'Sales',
                        ytitle : 'Number of Transactions',
                        path: '/api/getSalesMetrics/'
                        
                    },
                    reportSalesCtrl:{
                        path: '/api/report/sales'
                    },
                    reportInventoryCtrl:{
                        path: '/api/report/inventory'
                    },
                    reportReceiptCtrl:{
                        path: '/api/report/receipts'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/reportsController.js') }}
{{ HTML::script('bower_components/highcharts-release/highcharts.js') }}
{{ HTML::script('js/displaychart.js') }}
@stop
