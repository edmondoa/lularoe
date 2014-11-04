@extends('layouts.centered')
@section('content')
	<h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
	<p>
		{{ $userSite->body }}
	</p>
@stop
