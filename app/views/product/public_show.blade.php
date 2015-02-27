@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row">
		<div class="col-md-12">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">{{ $product->name }}</h1>
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
		        
		        <tr>
		            <th>Price:</th>
		            <td>
		            	@if(Session::get('party_id') != NULL)
		            		<s class="red">{{ money($product->retail_price) }}</s>
		            		<br>
		               		<strong class="font-size-2">{{ money($product->rep_price) }}</strong>
		               		<br>
		               		<div class="label label-default">You'll save {{ money($product->retail_price - $product->rep_price) }} by purchasing from {{ $organizer->full_name }}.</div>
		               	@else
		               		{{ money($product->retail_price) }}
		               	@endif
		            </td>
		        </tr>
		        
		        @if ($product->description != '')
			        <tr>
			            <th>Details:</th>
			            <td>{{ $product->description }}</td>
			        </tr>
			    @endif
		        
		        <tr>
		            <th>Category:</th>
		            <td>{{ $product->category_name }}</td>
		        </tr>
		        
		        @if (count($tags) > 0)
			        <tr>
			        	<th>Tags:</th>
			            <td class="tag-list">
			            	@foreach($tags as $tag)
				                <span class="label label-default">
				                	{{ $tag->name }}
				                </span>
			                @endforeach
			            </td>
			        </tr>
			    @endif
		        
		    </table>
		    {{ Form::open(['url' => 'cart', 'class' => 'pull-right']) }}
		    	<div class="form-group">
		    		{{ Form::hidden('product_id', $product->id) }}
		    		{{ Form::label('purchase_quantity', 'Quantity') }}
		    		{{ Form::number('purchase_quantity', 1, ['class' => 'form-control width-auto', 'style' => 'width:75px']) }}
		    	</div>
		    	<button class="btn btn-primary pull-right"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop
