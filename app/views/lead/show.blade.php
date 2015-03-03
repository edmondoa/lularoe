@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">{{ $lead->first_name }} {{ $lead->last_name }}</h1>

		@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep']))
		    <div class="btn-group pull-left margin-right-1" id="record-options">
			    <a class="btn btn-default" href="{{ url('leads/'.$lead->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    <!--
			    @if ($lead->disabled == 0)
				    {{ Form::open(array('url' => 'leads/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $lead->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'leads/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $lead->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
				-->
			    {{ Form::open(array('url' => 'leads/' . $lead->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete" style="border-top-right-radius:4px !important; border-bottom-right-radius:4px !important;">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
			{{ Form::open(array('url' => 'party-invite', 'method' => 'POST', 'class' => 'pull-left')) }}
			    {{ Form::hidden('leads', 1) }}
			    {{ Form::hidden('user_ids[]', $lead->id) }}
                <div class="margin-right-2">
                    <div class="input-group">
                        <select class="form-control selectpicker actions">
                            <option value="/party-invite" selected>Invite to Attend Your Party ...</option>
                            <option value="/party-host-invite">Invite to Host Your Party ...</option>
                            <option value="/users/email">Send Email</option>
                            <option value="/users/sms">Send Text (SMS)</option>
                        </select>
                        <div class="input-group-btn no-width">
                            <button class="btn btn-default applyAction">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
        	{{ Form::close() }}
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
		    <table class="table">
		        <tr>
		            <th>Contact ID:</th>
		            <td>{{ $lead->id }}</td>
		        </tr>		        
		        <tr>
		            <th>Email:</th>
		            <td>
		            	{{ Form::open(array('url' => '/users/email', 'method' => 'POST', 'class' => 'inline-block')) }}
		            		{{ Form::hidden('user_ids[]', $lead->id) }}
		            		{{ Form::hidden('leads', 1) }}
		            		<button title="Send Email"><i class="fa fa-envelope"></i></button>
		            	{{ Form::close() }}
		            	&nbsp;{{ $lead->email }}
		            </td>
		        </tr>

		        <tr>
		            <th>Phone:</th>
		            <td>
						{{ Form::open(array('url' => '/users/sms', 'method' => 'POST', 'class' => 'inline-block')) }}
		            		{{ Form::hidden('user_ids[]', $lead->id) }}
		            		{{ Form::hidden('leads', 1) }}
		            		<button style="width:32px;" title="Send Text Message (SMS)"><i class="fa fa-mobile-phone"></i></button>
		            	{{ Form::close() }}
		            	&nbsp;{{ $lead->formatted_phone }}
		            </td>
		        </tr>

		        <tr>
		            <th>Gender:</th>
		            <td>{{ $lead->gender }}</td>
		        </tr>
		        
		        <tr>
		            <th>Date of Birth:</th>
		            <td>{{ $lead->dob }}</td>
		        </tr>
		       
				@if (Auth::user()->hasRole(['Superadmin','Admin'])) 
			        <tr>
			            <th>Sponsor:</th>
			            <td>
			            	@if (isset($lead->sponsor->first_name))
			            		{{ $lead->sponsor->first_name }} {{ $lead->sponsor->last_name }}
			            	@endif
			            </td>
			        </tr>
			    @endif
		        
		        <tr>
		            <th>Promotion:</th>
		            <td>{{ $lead->opportunity_name }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
