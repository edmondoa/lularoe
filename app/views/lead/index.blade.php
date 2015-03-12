@extends('layouts.default')
@section('style')
	<style>
		#invite-to-party { margin-top:-25px; }
		@media(max-width:991px) {
		    #invite-to-party { float:none !important; margin-top:45px; }
		}
	</style>
@stop
@section('content')
<div ng-app="app" ng-controller="LeadController" class="index">
    {{ Form::open(array('url' => 'party-invite', 'method' => 'POST')) }}
    	{{ Form::hidden('leads', 1) }}
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All Contacts</h1>
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
		            <div class="col-md-10 col-sm-6 col-xs-12 page-actions-left">
		                <div class="pull-left">
		                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('leads/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left margin-right-2">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="/party-invite" selected>Invite to Attend Your Party ...</option>
		                                <option value="/party-host-invite">Invite to Host Your Party ...</option>
		                                <option value="/users/email">Send Email</option>
		                                <option value="/users/sms">Send Text (SMS)</option>
		                                <!-- <option value="leads/disable" selected>Disable</option>
		                                <option value="leads/enable">Enable</option> -->
		                                <option value="leads/delete">Delete</option>
		                            </select>
		                            <div class="input-group-btn no-width">
		                                <button class="btn btn-default applyAction" disabled>
		                                    <i class="fa fa-check"></i>
		                                </button>
		                            </div>
		                        </div>
		                    </div>
		                </div>
			        </div>
			        <div class="col-md-2 col-sm-6 col-xs-12">
		                <div class="input-group pull-right no-pull-xs">
		                    <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                    <span class="input-group-btn no-width">
		                        <button class="btn btn-default" type="button">
		                            <i class="fa fa-search"></i>
		                        </button>
		                    </span>
		                </div>
		            </div><!-- col -->
		        </div><!-- row -->
		     	<div class="row">
		     		<div class="col-md-12">
		     		</div>
		     	</div>
		    </div><!-- page-actions -->
	        <div class="row">
	            <div class="col col-md-12">
	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th>
	                            	<input type="checkbox">
	                            </th>
                        		
                            	<th class="link" ng-click="orderByField='last_name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'last_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link hidable-xs" ng-click="orderByField='email'; reverseSort = !reverseSort">Email
                            		<span>
                            			<span ng-show="orderByField == 'email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='phone'; reverseSort = !reverseSort">Phone
                            		<span>
                            			<span ng-show="orderByField == 'phone'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link hidable-sm" ng-click="orderByField='gender'; reverseSort = !reverseSort">Gender
                            		<span>
                            			<span ng-show="orderByField == 'gender'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link hidable-sm" ng-click="orderByField='dob'; reverseSort = !reverseSort">DOB
                            		<span>
                            			<span ng-show="orderByField == 'dob'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		@if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
	                            	<th class="link hidable-sm" ng-click="orderByField='sponsor_name'; reverseSort = !reverseSort">Sponsor
	                            		<span>
	                            			<span ng-show="orderByField == 'sponsor_name'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
                        		@endif
                        		
                            	<th class="link hidable-sm" ng-click="orderByField='opportunity_name'; reverseSort = !reverseSort">Promotion
                            		<span>
                            			<span ng-show="orderByField == 'opportunity_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link hidable-sm" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
                            		<span>
                            			<span ng-show="orderByField == 'updated_at'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="lead in leads | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="user_ids[]" value="@include('_helpers.lead_id')">
	                            </td>
								
					            <td>
					                <a href="/leads/@include('_helpers.lead_id')"><span ng-bind="lead.first_name"></span>, <span ng-bind="lead.last_name"></span></a>
					            </td>
					            
					            <td class="hidable-xs">
					                <span ng-bind="lead.email"></span>
					            </td>

					            <td>
					                <span ng-bind="lead.formatted_phone"></span>
					            </td>
					            
					            <td class="hidable-sm">
					                <span ng-bind="lead.gender"></span>
					            </td>
					            
					            <td class="hidable-sm">
					                <span ng-bind="lead.dob"></span>
					            </td>
					            
					            @if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
						            <td class="hidable-sm">
						                <span ng-bind="lead.sponsor_name"></span>
						            </td>
					            @endif
					            <td class="hidable-sm">
					                <span ng-bind="lead.opportunity_name"></span>
					            </td>
					            
					            <!-- <td>
					                <span ng-bind="lead.disabled"></span>
					            </td> -->
					            
					            <td class="hidable-sm">
					            	<span ng-bind="lead.updated_at"></span>
					            </td>
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

	// $('.applyAction').click(function() {
		// $('form').attr('action', $(this).parents('.input-group').children('select').val());
	// });

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function LeadController($scope, $http) {
	
		@if (Auth::check())
            if(Auth::user()->hasRole(['Superadmin', 'Admin'])) $object = 'all-leads';
			else $object = 'all-leads-by-rep/' . Auth::user()->id;
            
            $http.get('/api/{{ $object }}').success(function(leads) {
                $scope.leads = leads;
                console.log($scope.leads);
                @include('_helpers.bulk_action_checkboxes')
                
            });
        @endif;
	
		
		
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