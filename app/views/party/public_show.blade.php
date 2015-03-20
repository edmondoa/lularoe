@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row">
		<!-- @include('_helpers.breadcrumbs') -->
		<div class="col-md-12">
			<h1 class="no-top">{{ $party->name }}</h1>
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
			<p>{{ $party->description }}</p>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 div class="panel-title">Details</h2>
				</div>
			    <table class="table table-striped">
			        
			        @if ($party->local_start_date == $party->local_end_date)
				        <tr>
				            <th>Date/Time:</th>
				            <td>{{ $party->local_start_date }}, {{ $party->local_start_time }} - {{ $party->local_end_time }}</td>
				        </tr>
			        @else
				        <tr>
				        	<th>Local Start Time:</th>
				        	<td>{{ $party->local_start_date }}, {{ $party->local_start_time }}</td>
				        </tr>
				        <tr>
				        	<th>Local End Time:</th>
				        	<td>{{ $party->local_end_date }}, {{ $party->local_end_time }}</td>
				        </tr>
			        @endif
			        <tr>
			        	<th>Organizer:</th>
			        	<td><a href="//{{ $organizer->public_id }}.{{ Config::get('site.base_domain') }}">{{ $party->organizer_name }}</a></td>
			        </tr>
			        @if (isset($party->address))
				        <tr>
				        	<th>Host:</th>
				        	<td>{{ $party->host_name }}</td>
				        </tr>
				    @endif
			        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
	
				        <tr>
				            <th>Status:</th>
				            <td>{{ $party->status }}</td>
				        </tr>
				        
				        <tr>
				        	<th>Visibility:</th>
				        	<td>
				        		<table>
				        			<tr>
				        				<td>@if ($party->public == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Public</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->customers == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Customers</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->reps == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;FC's</td>
				        			</tr>
				        			<!--<tr>
				        				<td>@if ($party->editors == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Editors</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->admins == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Admins</td>
				        			</tr>-->
				        		</table>
				        	</td>
				        </tr>
			        @endif
			        
			    </table>
			</div><!-- panel -->
			@if (isset($address))
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 div class="panel-title">Address</h2>
					</div>
				    <table class="table table-striped">
				    	@if ($address->label != '')
					        <tr>
					            <td>{{ $address->label }}</td>
					        </tr>
					    @endif
				        <tr>
				            <td>{{ $address->address_1 }}</td>
				        </tr>
				        
				        @if (!empty($address->address_2))
					        <tr>
					            <td>{{ $address->address_2 }}</td>
					        </tr>
				        @endif
				        <tr>
				            <td>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</td>
				        </tr>
				    </table>
				</div><!-- panel -->
			@endif
		</div>
		<div class="col col-md-6">
			@if (isset($party->featured_image))
				<img id="featured-image" src="/uploads/{{ $party->featured_image->url }}" class="full-image">
			@endif
			@if (count($attachment_images) > 1)
				<div class="margin-top-2 product-thumbs">
					@foreach ($attachment_images as $attachment_image)
						<img src="/uploads/{{ $attachment_image }}" class="thumb thumb-md">
					@endforeach
				</div>
			@endif
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col-md-12 align-center">
			<hr>
			<a class="btn btn-primary" href="//{{ $organizer->public_id }}.{{ Config::get('site.base_domain') }}#contact-form"><i class="fa fa-user"></i> Contact {{ $party->organizer_name }}</a> <!-- <a href="/store" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Browse Store</a> -->
		</div>
	</div>
</div>
@stop