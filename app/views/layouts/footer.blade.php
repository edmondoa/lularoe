<div id='div_session_write'></div>
<div id="modals"></div>
		{{ HTML::script('/js/jquery1.js') }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js') }}
		{{ HTML::script('//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.2.js') }}
		{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
		{{ HTML::script('/packages/bootstrap-select/bootstrap-select.min.js') }}
		{{ HTML::script('packages/jquery-ui/jquery-ui-1.10.4.custom.min.js') }}
		<script>
		    // convert PHP variables to JavaScript
		    var domain = '{{ Config::get("site.domain") }}';
		    var path = '{{ Request::path() }}';
		
		</script>
		{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js') }}
		{{ HTML::script('js/functions.js') }}
		{{ HTML::script('/js/controllers/datepickerController.js') }}
		{{ HTML::script('/packages/jquery-ui/timepicker.js') }}
		<!--[javascript]-->
		@section('scripts')
		@show
		{{ HTML::script('/packages/dirpagination/dirPagination.js') }}
		{{ HTML::script('/packages/tinymce/tinymce.min.js') }}
		<!-- <script src="/packages/froala/js/froala_editor.min.js"></script> -->
		<!--[if lt IE 9]>
		<!-- Include IE8 JS. -->
		<!-- <script src="/packages/froala/js/froala_editor_ie8.min.js"></script> -->
		<![endif]-->
		@if (!Session::has('timezone'))
			<!-- get timezone -->
			<script>
			    // if (localStorage['timezone'] == undefined) {
			        // get timezone
			        var tz = jstz.determine();
			        // Determines the time zone of the browser client
			        var timezone = tz.name();
			        //'Asia/Kolhata' for Indian Time.
			        $.post('/set-timezone', { timezone : timezone });
			    // }
			</script>
		@endif
		<!-- ShopSocially plugin -->
		<script type='text/javascript'>
		    SSConfig = {
			partner_id: 'c951217223d677d6b72f8f839913a3b6' /*REQUIRED: Also known as Account ID */
		    };
		    _ssq = (typeof _ssq === 'undefined')?[]:_ssq;
		    _ssq.push(['init', SSConfig]);
		    (function() {
			var ss = document.createElement('script');ss.src = '//shopsocially.com/js/all.js';
			ss.type = 'text/javascript';ss.async = 'true';
			var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ss, s);
		    })();
		</script>
	</body>
</html>
@include('_helpers.store_previous_pages')
