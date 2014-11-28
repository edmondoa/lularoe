		{{ HTML::script('/js/jquery1.js') }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js') }}
		{{ HTML::script('//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.2.js') }}
		{{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
		{{ HTML::script('/packages/bootstrap-select/bootstrap-select.min.js') }}
		{{ HTML::script('packages/jquery-ui/jquery-ui-1.10.4.custom.min.js') }}
		<script>
		    // convert PHP variables to JavaScript
		    var path = '{{ Request::path() }}';
		
		</script>
		{{ HTML::script('js/functions.js') }}
		{{ HTML::script('/js/controllers/datepickerController.js') }}
		{{ HTML::script('/packages/jquery-ui/timepicker.js') }}
		<!--[javascript]-->
		@section('scripts')
		@show
		{{ HTML::script('/packages/dirpagination/dirPagination.js') }}
		<script src="/packages/froala/js/froala_editor.min.js"></script>
		<!--[if lt IE 9]>
		<!-- Include IE8 JS. -->
		<script src="/packages/froala/js/froala_editor_ie8.min.js"></script>
		<![endif]-->
	</body>
</html>