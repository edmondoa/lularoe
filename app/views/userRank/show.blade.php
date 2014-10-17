@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/userRanks">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing userRank</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('userRanks/'.$userRank->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($userRank->disabled == 0)
			    {{ Form::open(array('url' => 'userRanks/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $userRank->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'userRanks/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $userRank->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'userRanks/' . $userRank->id, 'method' => 'DELETE')) }}
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
		            <td>{{ $userRank->user_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Rank Id:</th>
		            <td>{{ $userRank->rank_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $userRank->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
