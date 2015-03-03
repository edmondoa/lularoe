@extends('layouts.public')
@section('content')
<div class="row">
    <div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <h2>Sign Up</h2>
        {{ Form::open(array('action' => 'PreRegisterController@store', 'class' => 'full')) }}
        {{ Form::hidden('sponsor_id', $sponsor->id) }}
        @if (isset($sponsor->id))
        <div class="alert alert-success">Your Sponsor is {{ $sponsor->first_name }} {{ $sponsor->last_name }}</div>
        @endif
        <iframe width="640" height="390" src="https://www.youtube.com/embed/dcfeshhmWrI" frameborder="0" allowfullscreen></iframe>
    </div>
</div>
@stop
