@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/pages">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing page</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('pages/'.$page->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($page->disabled == 0)
			    {{ Form::open(array('url' => 'pages/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $page->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'pages/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $page->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'pages/' . $page->id, 'method' => 'DELETE')) }}
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
		            <th>Title:</th>
		            <td>{{ $page->title }}</td>
		        </tr>
		        
		        <tr>
		            <th>Url:</th>
		            <td>{{ $page->url }}</td>
		        </tr>
		        
		        <tr>
		            <th>Type:</th>
		            <td>{{ $page->type }}</td>
		        </tr>
		        
		        <tr>
		            <th>Body:</th>
		            <td>{{ $page->body }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $page->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
