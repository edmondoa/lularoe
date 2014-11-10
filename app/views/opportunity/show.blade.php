@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing opportunity</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group">
			    <a class="btn btn-default" href="{{ url('opportunities/'.$opportunity->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($opportunity->disabled == 0)
				    {{ Form::open(array('url' => 'opportunities/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $opportunity->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'opportunities/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $opportunity->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'opportunities/' . $opportunity->id, 'method' => 'DELETE')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
		    <table class="table">
		        
		        <tr>
		            <th>Title:</th>
		            <td>{{ $opportunity->title }}</td>
		        </tr>
		        
		        <tr>
		            <th>Body:</th>
		            <td>{{ $opportunity->body }}</td>
		        </tr>
		        
		        <tr>
		            <th>Include Form:</th>
		            <td>{{ $opportunity->include_form }}</td>
		        </tr>
		        
		        <tr>
		            <th>Public:</th>
		            <td>{{ $opportunity->public }}</td>
		        </tr>
		        
		        <tr>
		            <th>Customers:</th>
		            <td>{{ $opportunity->customers }}</td>
		        </tr>
		        
		        <tr>
		            <th>Reps:</th>
		            <td>{{ $opportunity->reps }}</td>
		        </tr>
		        
		        <tr>
		            <th>Deadline:</th>
		            <td>{{ $opportunity->deadline }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
