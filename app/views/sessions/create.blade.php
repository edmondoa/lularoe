@extends('layouts.public')
@section('content')
	<div class="col-md-3 col-md-offset-1 col-sm-4">
		{{ Form::open(array('route' => 'sessions.store')) }}
	    <h1>Log In</h1>
		{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email Address')) }}
		<br>
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
		<br>
		<button class='btn btn-primary'>Log In</button>
		{{ Form::close() }}
		<br>
		<p><a href='/password/remind'>Forgot Password?</a>&nbsp; | &nbsp;<a href='/join'>Sign up</a></p>
	</div>
    <div class="col-md-7 col-md-offset-1 col-sm-8" style="padding-right: 0;padding-left: 0;">
        <img src="/img/llr_fall_2014_050.jpg" style="width:100%; position:relative; z-index:1000;">
    </div>
@stop
@section('classes')
home
@stop
@section('style')
.main-container{
margin-top: -0.4em;
}
@stop
@section('scripts')
	<script>
	
		// strip spaces from username
		function stripSpaces() {
			var text = jQuery('input[name="email"]').val().toLowerCase();
			text = text.replace(/\ /g, "");
			jQuery('input[name="email"]').val(text);
		}
		jQuery('input[name="email"]').keyup(function() {
			stripSpaces();
		});
		jQuery('input[name="email"]').on('paste', function () {
			var element = this;
			setTimeout(function() {
				stripSpaces();
			}, 100);
		});
		
	</script>
@stop
