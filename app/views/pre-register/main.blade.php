@extends('layouts.centered')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="MainController" class="my-controller">
        <base href="/u/" />
<!--
        <pre>$location.path() = @{{$location.path()}}</pre>
        <pre>$route.current.templateUrl = @{{$route.current.templateUrl}}</pre>
        <pre>user = @{{user}}</pre>
-->
        <div ng-view></div>
    </div>
</div>
<!-- app -->
@stop
@section('scripts')
<script>
    angular.extend(ControlPad, (function(){                
        return {
                preRegisterCtrl : {
                    path : '/api/preregister'
            }
        };
    }()));
</script>
{{ HTML::script('js/controllers/preregisterController.js') }}
@stop
