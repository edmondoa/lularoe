@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/userProducts">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing userProduct</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('userProduct/'.$userProduct->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($userProduct->disabled == 0)
			    {{ Form::open(array('url' => 'userProduct/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $userProduct->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'userProduct/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $userProduct->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'userProducts/' . $userProduct->id, 'method' => 'DELETE')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>Product Id:</th>
	            <td>{{ $userProduct->product_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $userProduct->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
