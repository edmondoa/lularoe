@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row">
		<div class="col-md-12">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">{{ $product->name }}</h1>
			@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
				<div class="page-actions">
				    <div class="btn-group" id="record-options">
					    <a class="btn btn-default" href="{{ url('products/'.$product->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
					    @if ($product->disabled == 0)
						    {{ Form::open(array('url' => 'products/disable', 'method' => 'DISABLE')) }}
						    	<input type="hidden" name="ids[]" value="{{ $product->id }}">
						    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
						    		<i class="fa fa-eye"></i>
						    	</button>
						    {{ Form::close() }}
						@else
						    {{ Form::open(array('url' => 'products/enable', 'method' => 'ENABLE')) }}
						    	<input type="hidden" name="ids[]" value="{{ $product->id }}">
						    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
						    		<i class="fa fa-eye"></i>
						    	</button>
						    {{ Form::close() }}
						@endif
					    {{ Form::open(array('url' => 'products/' . $product->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this product? This cannot be undone.");')) }}
					    	<button class="btn btn-default" title="Delete">
					    		<i class="fa fa-trash" title="Delete"></i>
					    	</button>
					    {{ Form::close() }}
					</div>
				</div>
			@endif
		</div><!-- col -->
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6 center">
			<p class="align-left">{{ $product->blurb }}</p>
			@if (isset($product->featured_image))
				<img id="featured-image" src="/uploads/{{ $product->featured_image->url }}" class="full-image">
			@endif
			@if (count($attachment_images) > 1)
				<div class="margin-top-2 product-thumbs">
					@foreach ($attachment_images as $attachment_image)
						<img src="/uploads/{{ $attachment_image }}" class="thumb thumb-md">
					@endforeach
				</div>
			@endif
		</div>
		<div class="col col-md-6">
		    <table class="table">
		        
		        @if ($product->description != '')
			        <tr>
			            <th>Description:</th>
			            <td>{{ $product->description }}</td>
			        </tr>
			    @endif
		        
		        <tr>
		            <th>Retail Price:</th>
		            <td>
		               	{{ money($product->retail_price) }}
		            </td>
		        </tr>

		        <tr>
		            <th>Rep Price:</th>
		            <td>
		               	{{ money($product->rep_price) }}
		            </td>
		        </tr>
		        
		        <tr>
		            <th>Quantity:</th>
		            <td>{{ $product->quantity }}</td>
		        </tr>
		        
		        <tr>
		            <th>Category Id:</th>
		            <td>{{ $product->category_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $product->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop