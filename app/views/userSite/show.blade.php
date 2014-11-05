@extends('layouts.centered')
@section('content')
	<h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
	<img src="/img/users/{{ $user->image }}" alt="{{ $user->first_name }} {{ $user->last_name }}">
	<p>
		{{ $userSite->body }}
	</p>
@stop
