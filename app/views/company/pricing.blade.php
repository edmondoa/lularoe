@extends('layouts.default')
@section('style')
	<style>
		h1 { color:#68c7c6; font-family:steelfish; font-size:4em; margin-bottom:0; }
		h2 { font-family:steelfish; font-size:2.35em; margin-top:.25em; }
		h2.pink { background:#f17498; padding:5px; color:white; margin-top:0; }
		h3 { font-family:steelfish; font-size:2.15em; color:#9594c8; border-bottom:1px solid #f17498; margin-bottom:0; }
		h4 { color:#f17498; font-size:2em; font-family:steelfish; margin-bottom:0; margin-top:.5em; }
		strong { color:#68c7c6; font-weight:100; margin:0; font-size:1.75em; font-family:maven; }
		thead th { text-align:center !important; }
		ul { padding-left:1em; margin:1em 0; }
		ul li { display:block; text-decoration:none; position:relative; margin-bottom:.5em; }
		ul li:before { content:'\2022'; font-size:1.5em; position:absolute; left:-.75em; top:-.2em; color:#fed141; }
		table { background:#68c7c6; margin:1em; color:white; text-align:center; }
		caption { background:#68c7c6; color:white; font-family:steelfish; font-size:2em; padding:0 10px; }
		th { font-size:.75em; font-weight:normal; border-bottom:1px solid #f17498; padding:10px 20px 3px; }
		td { font-size:1.75em; font-family:steelfish; padding:0 10px 10px; }
		small { color:black; font-size:.75em; line-height:1em; display:block; margin-left:1em; }
	</style>
@stop
@section('content')
	<div class="row">
		<div class="col col-md-12 align-center">
			<h1>AUDREY MERCHANT SOFTWARE</h1>
			<h2 class="pink">Simple pricing, powerful software</h2>
		</div><!-- col -->
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
			<h3>Debit Card</h3>
			<strong>2.69%</strong>
			<p>
				Debit Card Transactions, IOS app, and Audrey BackOffice<br>
				<small>-For a $100 debit transaction, you'll get $97.16 deposited into your bank account.</small>
			</p>
			<h3>Credit Card</h3>
			<strong>3.45% + 15&cent;</strong>
			<p>
				Credit Card Transactions, IOS app, and Audrey BackOffice<br>
				<small>-For a $100 credit transaction, you'll get $96.35 deposited into your bank account.</small>
			</p>
			<h3>More Features</h3>
			<ul>
				<li>Simple pricing for every sale</li>
				<li>Accept split sale transactions (2 cards at once)</li>
				<li>Get deposits funded directly into your bank account </li>
				<li>Auto pay Consignment</li>
				<li>Auto reserve funds for future inventory orders</li>
				<li>No sign-up fees</li>
				<li>No contracts</li>
				<li>No PCI-compliance fees</li>
				<li>Complete integration with your LuLaRoe Office Software</li>
			</ul>
		</div><!-- col -->
		<div class="col col-md-6 align-center">
			<h2 class="no-bottom">No Credit Card Reader Required!</h2>
			<p class="no-top">Scan debit/credit cards right from your device</p>
			<img width="200" src="/img/phone-visa-gift-card.jpg" alt="Phone showing Visa Gift Card">
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12 align-center">
			<h3>Why is Audrey a Better Value Than Other Providers?</h3>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-6">
			<table class="pull-right">
				<caption>Square Pricing:</caption>
				<thead>
					<tr>
						<th>Debit</th>
						<th>Credit</th>
						<th>Per Transaction</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>2.75%</td>
						<td>3.5%</td>
						<td>15&cent;</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col col-md-6">
			<h4>Disadvantages</h4>
			<ul>
				<li>Hardware required</li>
				<li>More expensive</li>
				<li>Not integrated with LuLaRoe backoffice solutions</li>
				<li>No tag scanning</li>
			</ul>
		</div>
	</div>
@stop
