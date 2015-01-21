<?php
	if (Auth::user()) $layout = 'default';
	else $layout = 'public';
?>
@extends('layouts.' . $layout)
@section('content')
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
			<h1 class="no-bottom">{{ $post->title }}</h1>
			<div class="date">
				@if ($post->publish_date != 0)
					{{ date('M d Y', strtotime($post->publish_date)) }}
				@else
					{{ date('M d Y', strtotime($post->created_at)) }}
				@endif
			</div>
			@if (isset($post->description))
				<p><em>{{ $post->description }}</em></p>
			@endif
			{{ $post->body }}
		</div><!-- col -->
	</div><!-- row -->
@stop
