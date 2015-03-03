		<div id="modals">
		    @section('modals')
		    @show
		</div>
		{{ HTML::script('/js/lib/jquery1.js') }}
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js') }}
        {{ HTML::script('//code.angularjs.org/1.2.0/angular-animate.min.js') }}
        {{ HTML::script('//code.angularjs.org/1.2.0/angular-route.min.js') }}
        {{ HTML::script('//code.angularjs.org/1.2.0/angular-resource.min.js') }}
		{{ HTML::script('//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.2.js') }}
		{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
		{{ HTML::script('/packages/bootstrap-select/bootstrap-select.min.js') }}
        {{ HTML::script('packages/jquery-ui/jquery-ui-1.10.4.custom.min.js') }}
        {{ HTML::script('/packages/angular-xeditable/js/xeditable.min.js') }}
		{{ HTML::script('packages/angular-growl-v2/build/angular-growl.min.js') }}
		<script>
		    // convert PHP variables to JavaScript
		    var domain = '{{ Config::get("site.domain") }}';
		    var path = '{{ Request::path() }}';
		
		</script>
		{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js') }}
		{{ HTML::script('js/functions.js') }}
        {{ HTML::script('js/services.js') }}
        {{ HTML::script('js/directives/validNumberDirective.js') }}
        {{ HTML::script('/js/controllers/datepickerController.js') }}
        {{ HTML::script('js/controllers.js') }}
		{{ HTML::script('js/app.js') }}
		{{ HTML::script('/packages/jquery-ui/timepicker.js') }}
		{{ HTML::script('/packages/dirpagination/dirPagination.js') }}
		{{ HTML::script('/packages/tinymce/tinymce.min.js') }}
		@if (!Session::has('timezone'))
			<!-- get timezone -->
			<script>
		        // get timezone
		        var tz = jstz.determine();
		        // Determines the time zone of the browser client
		        var timezone = tz.name();
		        //'Asia/Kolhata' for Indian Time.
		        $.post('/set-timezone', { timezone : timezone }, function(result) {
		        	//alert('Result!');
		        });
			</script>
		@endif
		@section('scripts1')
		@show
		@section('scripts')
		@show
		@section('scripts2')
		@show
		@section('scripts3')
		@show
	</body>
</html>
@include('_helpers.store_previous_pages')
