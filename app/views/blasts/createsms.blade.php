@extends('layouts.default')
@section('content')
@include('_helpers.breadcrumbs')
	<div class="row">
		<div class="col col-md-12">
			<h1>Send Text Message</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-4 col-md-6">
			{{ Form::open( array('route' => array('blast_sms'))) }}	
			
				<?php $i = 0; ?>
				@foreach ($users as $user)
					<input type='hidden' name='user_ids[{{ $i }}]' value='{{ $user->id }}'>
				@endforeach
				
				<div class="form-group">
					{{ Form::label('','To:') }}<br>
					@foreach ($users as $user)
						<span>
							<input type='hidden' name='user_ids[]' value='{{ $user->id }}'>
							<span class="label label-default">{{ $user->first_name }} {{ $user->last_name }} &nbsp;<i class="fa fa-times removeContact"></i></span>
						</span>
					@endforeach
					<br>
					<small>(Users who have opted out of receiving text messages will not be included.)</small>
				</div>
				
				<div class="form-group">
					{{ Form::label('message','Message:') }}
					{{ Form::textarea('message', null, ['id' => 'text_message', 'class' => 'form-control']) }}
				</div>
				
				<div class="form-group">
					<span id="charCount">135 characters left</span>
				</div>
				
				<div class="form-group">
					{{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
				</div>
		
			{{ Form::close() }}
		</div>
	</div>
@stop
@section('scripts')
    {{ HTML::script('js/smsCharacterCounter.js') }}
@stop
