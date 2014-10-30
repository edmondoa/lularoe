@extends('layouts.centered')
@section('content')
	<div class="row">
		<div class="col col-md-12">
			<h1>Reset Forgotten Password</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-3">
			<form action="{{ action('RemindersController@postRemind') }}" method="POST">
				<div class="form-group">
					<input type="email" name="email" placeholder="Your Email Address" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" value="Send Reset Link" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
@stop