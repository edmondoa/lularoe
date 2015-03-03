@extends('layouts.public')
@section('content')
<div class="row">
    <div class="col col-lg-7 col-md-7">
        <h2>Email confirmation sent.</h3>
        <p>We are so excited that you are interested in becoming a LuLaRoe Fashion Consultant. Kindly check your email to verify your account.</p>
        <iframe width="640" height="390" src="https://www.youtube.com/embed/dcfeshhmWrI" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="virtbar col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <h2>Join the Team</h2>
        @if (isset($sponsor->id))
        <div class="alert alert-success">Your Sponsor is {{ $sponsor->first_name }} {{ $sponsor->last_name }}</div>
        @endif
        <h4>Locate Consultants</h4>
        <div>
            <iframe src="https://batchgeo.com/map/7b47b86e72647f12495750a6dd0d42b8" frameborder="0" width="100%" height="250" style="border:1px solid #aaa;border-radius:10px;"></iframe>
        </div>
    </div>
</div>
@stop
