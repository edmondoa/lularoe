@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/bonuses">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing bonus</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('bonuses/'.$bonus->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($bonus->disabled == 0)
			    {{ Form::open(array('url' => 'bonuses/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $bonus->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'bonuses/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $bonus->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'bonuses/' . $bonus->id, 'method' => 'DELETE')) }}
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
		            <th>User Id:</th>
		            <td>{{ $bonus->user_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Eight In Eight:</th>
		            <td>{{ $bonus->eight_in_eight }}</td>
		        </tr>
		        
		        <tr>
		            <th>Twelve In Twelve:</th>
		            <td>{{ $bonus->twelve_in_twelve }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $bonus->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
