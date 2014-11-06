@extends('layouts.gray')
@section('classes')
	user-site
@stop
@section('banner')
	<div class="user-banner-container container">
		<img class="user-banner" src="{{ $userSite->banner }}" alt="{{ $user->first_name }} {{ $user->last_name }}'s banner">
		<div class="user-banner-text">
			<div class="user-banner-content overflow-hidden">
				<div class="pull-left">
					<h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
					<small>Independent Social Marketer &nbsp;|&nbsp; Rank: {{ $user->rank_name }}</small>
				</div>
				<div class="pull-right">
					<a class="btn btn-primary" onclick="scrollTo('#contact-form')">Contact {{ $user->first_name }}</a>
				</div>
			</div>
		</div>
		<img class="avatar" width="200" height="200" src="{{ $user->image }}" alt="{{ $user->first_name }} {{ $user->last_name }}">
	</div>
@stop
@section('content')
	<div class="row">
	    <div class="col col-md-9">
	        <div class="col col-md-12">
	            {{ $userSite->body }}
	        </div>
	
	        <div class="col col-md-6" id="contact-form">
	            <h2>Contact {{ $user->first_name }}</h2>
	            {{ Form::open( array('action' => 'BlastController@StoreMail')) }}
	            
					<input type='hidden' name='user_ids[]' value='{{ $user->id }}'>
					
		            <div class="form-group">
		                {{ Form::label('subject_line','*Subject:')}}
		                {{ Form::text('subject_line',null,  $attributes = array('class'=>'form-control')) }}
		            </div>
		
		            <div class="form-group">
		                {{ Form::label('body','*Message:')}}
		                {{ Form::textarea('body',null,  $attributes = array('class'=>'form-control')) }}
		            </div>
		
		            <div class="form-group">
		                {{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
		            </div>
		            
	            {{ Form::close() }}
	        </div>
	    </div>
		<div class="col col-md-3 list-group">
			<h3 class="no-top">Upcoming Events</h3>
			@foreach ($events as $event)
				<a class="list-group-item" href="/events/{{ $event->id }}">
					{{ $event->name }}<br><small>{{ $event->formatted_start_date }}</small>
				</a>
			@endforeach
		</div>
	</div>
@stop
