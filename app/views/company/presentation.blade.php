@extends('layouts.public')
@section('content')
	<div class="align-center">
		<h1>{{ Config::get('site.company_name') }} Presentation</h1>
	    <h2>{{ Config::get('site.company_name') }} Overview Presentation English</h2>
		<iframe width="420" height="315" src="//www.youtube.com/embed/" frameborder="0" allowfullscreen></iframe>
		<br>
		<h2>{{ Config::get('site.company_name') }} Overview Presentacion Español</h2>
		<iframe width="560" height="315" src="//www.youtube.com/embed/" frameborder="0" allowfullscreen></iframe>
	</div>
@stop
