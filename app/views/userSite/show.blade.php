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
					<small>Fashion Consultant &nbsp;|&nbsp; Rank: {{ $user->rank_name }}</small>
				</div>
				<div class="pull-right align-right">
					<!-- <a class="btn btn-primary" onclick="scrollTo('#contact-form')">Contact {{ $user->first_name }}</a> -->
					@if (!$user->hide_phone)
						<div class="margin-top-1"><i class="fa fa-mobile-phone"></i> {{ $user->formatted_phone }}</div>
					@endif
					@if (!$user->hide_email)
						<div><i class="fa fa-envelope"></i> {{ $user->email }}</div>
					@endif
				</div>
			</div>
		</div>
		<img class="avatar" width="200" height="200" src="{{ $user->image }}" alt="{{ $user->first_name }} {{ $user->last_name }}">
	</div>
@stop
@section('content')
	<div class="row">
	    <div class="col col-md-9">
        	@if (isset($userSite->body))
        		<h2 class="no-top">{{ $userSite->title }}</h2>
        	@endif
            @if (isset($userSite->body))
	            {{ $userSite->body }}
	        @endif
	        <br>
        	<div class="col col-md-6 no-padding" id="contact-form">
	            <h2>Contact {{ $user->first_name }}</h2>
	            {{ Form::open(array('action' => 'send-contact-form')) }}
	            
	            	<input type='hidden' name='user_id' value='{{ $user->id }}'>
					
		            <div class="form-group">
		                {{ Form::label('name','*Name:')}}
		                {{ Form::text('name', null, ['class'=>'form-control']) }}
		            </div>
		            
		            <div class="form-group">
		                {{ Form::label('email','*Email Address:')}}
		                {{ Form::text('email', null, ['class'=>'form-control']) }}
		            </div>
					
		            <div class="form-group">
		                {{ Form::label('subject_line','*Subject:')}}
		                {{ Form::text('subject_line', null, $attributes = array('class'=>'form-control')) }}
		            </div>
		
		            <div class="form-group">
		                {{ Form::label('body','*Message:')}}
		                {{ Form::textarea('body',null, $attributes = array('class'=>'form-control')) }}
		            </div>
		
		            <div class="form-group">
		                {{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
		            </div>
		            
	            {{ Form::close() }}
	        </div>
		</div>
		<div class="col col-md-3">
			@foreach ($addresses as $address)
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 div class="panel-title">Address</h2>
					</div>
				    <table class="table table-striped">
				        <tr>
				            <td>{{ $address->address_1 }}</td>
				        </tr>
				        
				        @if (!empty($address->address_2))
					        <tr>
					            <td>{{ $address->address_2 }}</td>
					        </tr>
				        @endif
				        <tr>
				            <td>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</td>
				        </tr>
				    </table>
				</div><!-- panel -->
			@endforeach
			<!-- <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Current Opportunities</h3>
				</div>
				<div class="list-group">
					@foreach ($opportunities as $opportunity)
						<a class="list-group-item" href="/opportunity/{{ $opportunity->id }}">
							{{ $opportunity->title }}
						</a>
					@endforeach
				</div>
			</div> -->
			<!-- <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Upcoming Events</h3>
				</div>
				<div class="list-group">
					@foreach ($events as $event)
						<a class="list-group-item" href="/public-events/{{ $event->id }}">
							{{ $event->name }}<br><small>{{ $event->formatted_start_date }}</small>
						</a>
					@endforeach
				</div>
			</div> -->
		</div>
	</div>
@stop
@section('scripts')
    <script>
    
	    // smoothly scroll to an element
	    function scrollTo(element) {
	        $('html, body').animate({
	            scrollTop: $(element).offset().top
	        }, 2000);
	    }
	    
    </script>
@stop
