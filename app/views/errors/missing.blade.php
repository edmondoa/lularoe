@extends(empty(Auth::user()) || !Auth::user()->hasRole(array('Superadmin', 'Admin')) ? 'layouts.public' :'layouts.default' )
@section('content')
<div class="row">
    <div class="col col-md-8">
        <h1>Sorry, page not found.</h1>
        <p>You may be trying to accessa page that may no longer exists. If you believe this is a mistake, kindly get our attention using our <a href="contact-us">contact us</a> page. Thank you.</p>
    </div>
</div>
@stop
