@extends('layouts.default')
@section('style')
	<style>
		thead th { text-align:center !important; }
		ul { padding-left:1em; }
	</style>
@stop
@section('content')
	<div class="row">
		<div class="col col-md-12">
			<h1>{{ Config::get('site.company_name') }} Transaction Rates</h1>		
		</div><!-- col -->
	</div><!-- row -->
	<div class="row">
		<div class="col col-lg-4 col-md-6 col-sm-6">
			<table class="table align-center width-auto">
				<thead>
					<tr>
						<th>Debit</th>
						<th>Credit</th>
						<th>Per Transaction</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h2 class="no-top">2.69%</h2></td>
						<td><h2 class="no-top">3.45%</h2></td>
						<td><h2 class="no-top">+ 15&cent;</h2></td>
					</tr>
				</tbody>
			</table>
			<p>
				<strong>For a $100 debit transaction, you'll get $97.16 deposited into your bank account in one to two business days.</strong>
			</p>
			<ul>
				<li>Consistent rates for every card. No hidden fees or charges.</li>
				<li>Accept Visa, MasterCard, Discover, and American Express.</li>
				<li>Get deposits in your bank account in one to two business days.</li>
				<li>Lowest proccessing rates out there.</li>
			</ul>
		</div><!-- col -->
	</div><!-- row -->
@stop
