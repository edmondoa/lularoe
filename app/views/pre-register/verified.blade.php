@extends('layouts.centered')
@section('content')
<div class="row">
    <div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <h2>@if($status == 'verified') 
                Email successfully verified.
            @elseif($status == 'AlreadyVerified')
                Email already verified.
            @endif
            </h2>
        <p>Continue to <a href="/dashboard">Dashboard</a></p>
    </div>
</div>
@stop