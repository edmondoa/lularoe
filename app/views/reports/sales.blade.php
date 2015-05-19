@extends('layouts.default')
@section('content')
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div class="index">
	<h1>Sales Reports</h1>

	<div class="panel well" id="dashboard">
		<div id="filter_div"></div>
		<div id="category_div"></div>
		<div id="sales"></div>
		<div id="financials_chart"></div>
		<div id="itemsales_daily"></div>
		<div id="dailysales_table"></div>
		<div id="dailysales_bar"></div>
	</div>

</div><!-- app -->
<script>
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1', {'packages':['corechart','bar','table','controls']});


	function itemSalesByDay(chartable) {
		var chart = new google.visualization.Table(document.getElementById('itemsales_daily'));

		var chartinfo = google.visualization.arrayToDataTable([
			['Day', 'Item1', 'Item2', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
			['2004/05',  165,      938,         522,             998,           450,      614.6],
			['2005/06',  135,      1120,        599,             1268,          288,      682],
			['2006/07',  157,      1167,        587,             807,           397,      623],
			['2007/08',  139,      1110,        615,             968,           215,      609.4],
			['2008/09',  136,      691,         629,             1026,          366,      569.6]
		  ]);

		//chart.draw(chartinfo);
	}

	function financials(dashboard, controller, chartable) {
			
		var itemsales = new google.visualization.DataTable();
		var money = new google.visualization.NumberFormat({prefix: '$'});
		var numeric = new google.visualization.NumberFormat({fractionDigits : 0});

		// Set up the columns
		itemsales.addColumn('datetime','Date');
		itemsales.addColumn('number','Tax');
		itemsales.addColumn('number','Subtotal');
		itemsales.addColumn('number','Total');

		// Instantiate and draw our chart, passing in some options.
		$.each(chartable.sales,function(datesold,itemdata) {
			itemsales.addRows([[new Date(datesold),itemdata.tax,itemdata.subtotal,itemdata.total]]);
		});

		itemsales.sort([{column: 0, desc: true}]);

		money.format(itemsales, 3); // Apply formatter to second column
		money.format(itemsales, 2); // Apply formatter to second column
		money.format(itemsales, 1); // Apply formatter to second column

		var dailySalesChart  = new google.visualization.ChartWrapper({
				'chartType': 'Table',
				'containerId': 'financials_chart',
				'options': {
				  'width': 900,
				  'height': 700,
				  'legend': 'none',
				  'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
				  'pieSliceText': 'value'
				}
			  });

		dashboard.bind(controller, dailySalesChart);
		dashboard.draw(itemsales);
	}

	function bestSellers(dashboard, controller, chartable) {
			
		var itemsales = new google.visualization.DataTable();
		var money = new google.visualization.NumberFormat({prefix: '$'});
		var numeric = new google.visualization.NumberFormat({fractionDigits : 0});

		// Set up the columns
		itemsales.addColumn('datetime','Date');
		itemsales.addColumn('string','Item');
		itemsales.addColumn('number','# Sold');
		itemsales.addColumn('number','Total');

		// Instantiate and draw our chart, passing in some options.
		$.each(chartable.sellers,function(datesold,itemdata) {
			$.each(itemdata,function(itemname,item) {
				itemsales.addRows([[new Date(datesold),itemname,item.count,item.total]]);
			});
		});

		itemsales.sort([{column: 0, desc: true}]);

		money.format(itemsales, 3); // Apply formatter to second column
		numeric.format(itemsales, 2); // Apply formatter to second column

		var dailySalesChart  = new google.visualization.ChartWrapper({
				'chartType': 'Table',
				'containerId': 'dailysales_table',
				'options': {
				  'width': 900,
				  'height': 700,
				  'legend': 'none',
				  'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
				  'pieSliceText': 'value'
				}
			  });

		dashboard.bind(controller, dailySalesChart);
		dashboard.draw(itemsales);
	}

	function getSum(data, column) {
		var total = 0;
		for (i = 0; i < data.getNumberOfRows(); i++) {
			console.log(data);
		  total = total + data.getValue(i, column);
		}
		return total;
	}

	$(document).ready(function() { 
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard'));
		var dateSlider = new google.visualization.ControlWrapper({
	   'controlType': 'ChartRangeFilter',
		'containerId': 'filter_div',
			'options': {
				'filterColumnIndex': 0,
				'ui': {
					'chartOptions' : {
						'height':'80',
						'chartArea': { 'height' : 60 },
						'hAxis' : { 'textPosition' : 'out' },
					},
					'chartView': { 'columns': [0, 2] }
				}
			}
		});
		jQuery.get('/api/report/chartable',function(chartable) {
			financials(dashboard,dateSlider,chartable);
	//		bestSellers(dashboard,dateSlider,chartable);
		});
	});

</script>
@stop
@section('scripts')
@stop
