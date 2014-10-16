@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/images">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing image</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('image/'.$image->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($image->disabled == 0)
			    {{ Form::open(array('url' => 'image/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $image->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'image/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $image->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'images/' . $image->id, 'method' => 'DELETE')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>Type:</th>
	            <td>{{ $image->type }}</td>
	        </tr>
	        
	        <tr>
	            <th>Url:</th>
	            <td>{{ $image->url }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $image->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
