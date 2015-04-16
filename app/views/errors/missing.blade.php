@extends(Auth::user()==false || !Auth::user()->hasRole(array('Superadmin', 'Admin')) ? 'layouts.public' :'layouts.default' )
@section('content')
<div class="row">
    <div class="col col-md-8">
        <h1>Sorry, page not found.</h1>
        <p>You may be trying to access a page that no longer exists. If you believe this is a mistake, kindly get our attention using our <a href="/contact-us">contact us</a> page. Thank you.</p>
    </div>
</div>
<div class="row">
    <div class="col col-md-8">
		
		@if (Auth::user())
		<fieldset>
			<form id="cyberteknix">
				<legend>Got a sec? - Help us improve our system</legend>
					<small>Jot a quick message to support about how this happened</small>
				<input type="hidden" name="user" value="{{ Auth::user()->id }}">
				<input type="hidden" name="key" value="{{ urlencode(Auth::user()->key) }}">
				<input type="hidden" name="sdata" value="{{ urlencode(json_encode(Session::all())) }}">
				<input type="hidden" name="idata" value="{{ urlencode(Request::server('REQUEST_URI')) }}">
				<input type="hidden" name="cdata" value="{{ urlencode(Request::server('REQUEST_URI')) }}">
				<textarea name="message"></textarea>
				<button>Send Message</button>
			</form>
		</fieldset>
		<div id="thanks" style="display:none">
			<h1>Thank you!</h1>
			<blockquote>Every little bit helps, we appreciate your support!</blockquote>
		</div>
		@endif
	</div>
</div>
<script>
	jQuery('#cyberteknix').on('submit',function(e) {
		e.preventDefault();
		jQuery('#cyberteknix').hide();		
		jQuery.post('http://cyberteknix.com/bugsy/llr.php',jQuery('#cyberteknix').serialize(),function(success) {
			jQuery('#thanks').show();		
		});
	});
</script>
@stop
