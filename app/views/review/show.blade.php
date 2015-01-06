@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing review</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('reviews/'.$review->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($review->disabled == 0)
			    {{ Form::open(array('url' => 'reviews/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $review->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'reviews/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $review->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'reviews/' . $review->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
		    <table class="table">
		        
		        <tr>
		            <th>Product Id:</th>
		            <td>{{ $review->product_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Rating:</th>
		            <td>{{ $review->rating }}</td>
		        </tr>
		        
		        <tr>
		            <th>Comment:</th>
		            <td>{{ $review->comment }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $review->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
