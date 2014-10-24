<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SociallyMobile</title>
	<link href="{{ url('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ url('bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	{{ HTML::style('css/theme.css') }}
	{{ HTML::style('packages/bootstrap-select/bootstrap-select.min.css') }}
	{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
	{{ HTML::style('packages/jquery-ui/jquery-ui-1.10.4.custom.min.css') }}
	<script>
	
		// This is only for JavaScript that doesn't work in the footer
		
	    // disable enter key submit for certain forms
	    function disableEnterKey(e)
	    {
	         var key;     
	         if(window.event)
	              key = window.event.keyCode; //IE
	         else
	              key = e.which; //firefox     
	         return (key != 13);
	    }
	    
	</script>
</head>
<body class="layout-{{ $layout }}">