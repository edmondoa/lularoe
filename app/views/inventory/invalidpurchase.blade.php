@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
        <div ng-controller="InventoryController" class="my-controller">
			<h1>There was an error with your order</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h3>Your purhcase did not complete</h3>
                    <div ng-if="isEmpty()">
						<div class="well">
							<div class="row">
								<h4>Some error message here</h4>
							</div>
						</div>
                    </div>
                </div>
            </div>
    </div><!-- app -->
@stop
