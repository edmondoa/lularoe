@extends('layouts.default')
@section('content')
	@include('_helpers.breadcrumbs')
	<div class="row">
		<div class="col col-md-12">
			<h1>Send Email</h1>
			<div class="row">
		</div>
	</div>
		<div class="col col-md-6">
			{{ Form::open( array('route' => array('blast_email'))) }}
			
				<div class="form-group">
					{{ Form::label('subject_line','To:')}}<br>
					@foreach ($users as $user)
						<span>
							<input type='hidden' name='user_ids[]' value='{{ $user->id }}'>
							<span class="label label-default">{{ $user->first_name }} {{ $user->last_name }} &nbsp;<i class="fa fa-times"></i></span>
						</span>
					@endforeach
				</div>
		
				<div class="form-group">
					{{ Form::label('subject_line','*Subject:')}}
					{{ Form::text('subject_line',null,  $attributes = array('class'=>'form-control')) }}
				</div>
		
				<div class="form-group">
					{{ Form::label('body','Message:')}}
					{{ Form::textarea('body',null,  $attributes = array('class'=>'wysiwyg')) }}
				</div>
		
				<div class="form-group">
					{{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
				</div>
		
			{{ Form::close() }}
		</div>
	</div>
@stop