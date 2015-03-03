@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'opportunities/disable', 'method' => 'POST')) }}
	    <div ng-controller="OpportunityController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All Promotions</h1>
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
		        	@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
			    		<div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
			                <div class="pull-left">
			                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('opportunities/create') }}"><i class="fa fa-plus"></i></a>
			                    <div class="pull-left">
			                        <div class="input-group">
			                            <select class="form-control selectpicker actions">
			                                <option value="events/disable" selected>Disable</option>
			                                <option value="events/enable">Enable</option>
			                                <option value="events/delete">Delete</option>
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
			        	<div class="col-md-6 col-sm-6 col-xs-12">
					@else
						<div class="col-md-12 col-sm-12 col-xs-12">
					@endif
		                <div class="pull-right">
		                    <div class="input-group">
		                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                        <span class="input-group-btn no-width">
		                            <button class="btn btn-default" type="button">
		                                <i class="fa fa-search"></i>
		                            </button>
		                        </span>
		                    </div>
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
                            	
                            	<th class="link" ng-click="orderByField='title'; reverseSort = !reverseSort">Title
                            		<span>
                            			<span ng-show="orderByField == 'title'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='deadline'; reverseSort = !reverseSort">Deadline
                            		<span>
                            			<span ng-show="orderByField == 'deadline'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                        		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
	                            	<th class="link" ng-click="orderByField='public'; reverseSort = !reverseSort">Public
	                            		<span>
	                            			<span ng-show="orderByField == 'public'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        		
	                            	<th class="link" ng-click="orderByField='customers'; reverseSort = !reverseSort">Customers
	                            		<span>
	                            			<span ng-show="orderByField == 'customers'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        		
	                            	<th class="link" ng-click="orderByField='reps'; reverseSort = !reverseSort">FC's
	                            		<span>
	                            			<span ng-show="orderByField == 'reps'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	
	                            	<th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
	                            		<span>
	                            			<span ng-show="orderByField == 'disabled'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	
	                            	<th class="link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
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
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="opportunity in opportunities | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage"  total-items="countItems">
	                            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		                            <td ng-click="checkbox()">
		                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.opportunity_id')">
		                            </td>
	                            @endif
								
					            <td>
					            	@if (Auth::user()->hasRole(['Superadmin','Admin']))
					                	<a href="/opportunities/@include('_helpers.opportunity_id')"><span ng-bind="opportunity.title"></span></a>
					            	@else
					                	<a target="_blank" href="/opportunity/@include('_helpers.opportunity_id')"><span ng-bind="opportunity.title"></span></a>
					            	@endif
					            </td>
					            
					            <td>
					                <span ng-bind="opportunity.formatted_deadline_date"></span>
					            </td>
					            
					            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
						            <td class="hidable-sm boolean border">
						                <span ng-if="opportunity.public"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td class="hidable-sm boolean border">
						                <span ng-if="opportunity.customers"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td class="hidable-sm boolean border">
						                <span ng-if="opportunity.reps"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td class="hidable-sm boolean border">
						                <span ng-if="opportunity.disabled"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td>
						            	<span ng-bind="opportunity.updated_at"></span>
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
    angular.extend(ControlPad, (function(){                
                return {
                    opportunityCtrl : {
                        path : '/api/all-opportunities'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/opportunityController.js') }}
@stop