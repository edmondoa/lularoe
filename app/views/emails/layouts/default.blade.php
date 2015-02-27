<html>
	<body>
		@section('body')
		@show
		<p><img src="http://{{ Config::get('site.domain') }}/img/iap-logo.png" alt="{{ Config::get('site.company_name') }}"></p>
	</body>
</html>
