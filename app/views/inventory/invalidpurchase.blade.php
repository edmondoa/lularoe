@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
        <div ng-controller="InventoryController" class="my-controller">
			<h1>There was an error with your order</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h3>Your purhcase did not complete</h3>
					<div class="row">
						<blockquote>{{ $cardauth->status; }}</blockquote>
						@if (isset($checking))
							<div class="col-sm-6">
								<a class="btn btn-primary" href="/bankinfo/{{ $checking->id }}/edit">Click here to update account info</a>
							</div>
						@else
							<p>Click back to try again</p>
						@endif
					</div>
                </div>
            </div>
    </div><!-- app -->
@stop
