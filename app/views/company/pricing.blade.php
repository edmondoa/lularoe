@extends('layouts.default')
@section('style')
	<style>
		h1 { color:#68c7c6; font-family:oswald; }
		h3 { color:#9594c8; border-bottom:1px solid #f17498; }
		thead th { text-align:center !important; }
		ul { padding-left:1em; }
		bullet color #fed141
		pink #f17498
		purple #9594c8
		table { background:#68c7c6; }
	</style>
@stop
@section('content')
	<div class="row">
		<div class="col col-md-12">
			<h1>AUDREY MERCHANT SOFTWARE</h1>
			<h2>Simple pricing, powerful software</h2>
		</div><!-- col -->
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
			<h3>Debit Card</h3>
			<strong>2.69%</strong>
			<p>Debit Card Transactions, IOS app, and Audrey BackOffice</p>
			<p><small>-For a $100 debit transaction, you'll get $97.16 deposited into your bank account.</small></p>
			<h3>Credit Card</h3>
			<strong>3.45% + 15&cent;</strong>
			<p>Credit Card Transactions, IOS app, and Audrey BackOffice</p>
			<p><small>-For a $100 credit transaction, you'll get $96.35 deposited into your bank account.</small></p>
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
		<div class="col col-md-6">
			<h2>No Credit Card Reader Required!</h2>
			<p>Scan debit/credit cards right from your device</p>
			<img src="/img/phone-visa-gift-card.jpg" alt="Phone showing Visa Gift Card">
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
			<h3>Why is Audrey a Better Value Than Other Providers?</h3>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-6">
			<table>
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
