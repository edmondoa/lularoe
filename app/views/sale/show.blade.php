@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/sales">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing sale</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('sales/'.$sale->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($sale->disabled == 0)
			    {{ Form::open(array('url' => 'sales/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $sale->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'sales/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $sale->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'sales/' . $sale->id, 'method' => 'DELETE')) }}
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
		            <td>{{ $sale->product_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>User Id:</th>
		            <td>{{ $sale->user_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Sponsor Id:</th>
		            <td>{{ $sale->sponsor_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Quantity:</th>
		            <td>{{ $sale->quantity }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $sale->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
