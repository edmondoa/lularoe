@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'parties/disable', 'method' => 'POST')) }}
	    <div ng-controller="partyController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">{{ ucfirst($range) }} Pop-Up Boutiques</h1>
		            	<div class="pull-right hidable-xs">
		                    <div class="input-group pull-right">
		                    	<span class="input-group-addon no-width">Count</span>
		                    	<input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
		                    </div>
		                    <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
		            	</div>
			    	</div>
		        </div><!-- row -->
		        <div class="row">
		        	@if (Auth::user()->hasRole(['Superadmin', 'Admin','Rep']))
			    		<div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
			                <div class="pull-left">
			                	@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
			                    	<a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('parties/create') }}"><i class="fa fa-plus"></i></a>
				                @elseif (Auth::user()->hasRole(['Rep']))
			                    	<a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('parties/create') }}"><i class="fa fa-plus"></i> New Pop-Up Boutique</a>
				                @endif
				                @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
				                    <div class="pull-left">
				                        <div class="input-group">
				                            <select class="form-control selectpicker actions">
				                                <option value="parties/disable" selected>Disable</option>
				                                <option value="parties/enable">Enable</option>
				                                <option value="parties/delete">Delete</option>
				                            </select>
				                            <div class="input-group-btn no-width">
				                                <button class="btn btn-default applyAction" disabled>
				                                    <i class="fa fa-check"></i>
				                                </button>
				                            </div>
				                        </div>
				                    </div>
				            	@endif
			                </div>
			        	</div>
			        	<div class="col-md-6 col-sm-6 col-xs-12">
					@else
						<div class="col-md-12 col-sm-12 col-xs-12">
					@endif
	                    <div class="input-group pull-right no-pull-xs">
	                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(party)" type="text">
	                        <span class="input-group-btn no-width">
	                            <button class="btn btn-default" type="button">
	                                <i class="fa fa-search"></i>
	                            </button>
	                        </span>
	                    </div>
		            </div><!-- col -->
		        </div><!-- row -->
		    </div><!-- page-actions -->
	        <div class="row">
	            <div class="col col-md-12">
	                <table class="table">
	                    <thead>
	                        <tr>
	                        	@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		                            <th>
		                            	<input type="checkbox">
		                            </th>
		                        @endif
		                        
                            	<th class="link hidable-xs" ng-click="orderByField='date_start'; reverseSort = !reverseSort">Date
                            		<span>
                            			<span ng-show="orderByField == 'date_start'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                        		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
	                            	<th class="link" ng-click="orderByField='organizer_name'; reverseSort = !reverseSort">Organizer
	                            		<span>
	                            			<span ng-show="orderByField == 'organizer_name'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        	@endif
                            	
                            	<th class="link" ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                        		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
	                            	<th class="link hidable-sm" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
	                            		<span>
	                            			<span ng-show="orderByField == 'updated_at'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        	@endif
	                        	
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-class="{ highlight : party.new == 1, semitransparent : party.disabled == 1 }" dir-paginate-start="party in parties | filter:search | orderBy:'<?php if ($range == 'past') echo '-' ?>date_start' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
		                        
		                        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		                            <td ng-click="checkbox()">
		                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.party_id')">
		                            </td>
								@endif
								
					            <td class="date-col hidable-sm">
					                <span ng-bind="party.local_start_date"></span>
					            </td>
							
					            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))				            
						            <td class="date-col">
						                <span ng-bind="party.organizer_name"></span>
						            </td>
						        @endif
								
					            <td>
					                <a href="/parties/{{'{'.'{party.id}'.'}'}}"><span ng-bind="party.name"></span></a>
					            </td>
					            
					            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))				            
						            <td class="hidable-sm">
						            	<span ng-bind="party.updated_at"></span>
						            </td>
						    	@endif
						    	
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                @include('_helpers.loading')
	                <div ng-controller="OtherController" class="other-controller">
	                    <div class="text-center">
	                        <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
	                    </div>
	                </div>
	            </div><!-- col -->
	        </div><!-- row -->
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function partyController($scope, $http) {
		
		$http.get('/api/all-{{ $range }}-parties').success(function(parties) {
			$scope.parties = parties;
			console.log($scope.parties);
			@include('_helpers.bulk_action_checkboxes')

		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.meals = [];
		
		$scope.pageChangeHandler = function(num) {
			
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop