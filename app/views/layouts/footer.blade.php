{{ HTML::script('/js/jquery1.js') }}
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
{{ HTML::script('/packages/bootstrap-select/bootstrap-select.min.js') }}
{{ HTML::script('packages/jquery-ui/jquery-ui-1.10.4.custom.min.js') }}
<script>
	
	// convert PHP variables to JavaScript
	var url = '{{ Request::url() }}';
	
</script>
{{ HTML::script('js/functions.js') }}
<script src="/js/controllers/datepickerController.js"></script>
<!--[javascript]-->
@section('scripts')
@show
<script src="/packages/dirpagination/dirPagination.js"></script>
</body>
</html>