@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col col-md-12">
        <h1>Welcome, {{ $user->first_name }}</h1>
        <p>Thank you for signing up! Let me help you get started.</p>
        
    </div>
</div><!-- row -->
@stop
