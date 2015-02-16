@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'profiles/disable', 'method' => 'POST')) }}
	    <div ng-controller="ProfileController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All Profiles</h1>
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
		            <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
		                <div class="pull-left">
		                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('profiles/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="profiles/disable" selected>Disable</option>
		                                <option value="profiles/enable">Enable</option>
		                                <option value="profiles/delete">Delete</option>
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
		    </div><!-- page-actions -->
	        <div class="row">
	            <div class="col col-md-12">
	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th>
	                            	<input type="checkbox">
	                            </th>
                            	
                            	<th class="link" ng-click="orderByField='public_name'; reverseSort = !reverseSort">Public Name
                            		<span>
                            			<span ng-show="orderByField == 'public_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='public_content'; reverseSort = !reverseSort">Public Content
                            		<span>
                            			<span ng-show="orderByField == 'public_content'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_company_email'; reverseSort = !reverseSort">Receive Company Email
                            		<span>
                            			<span ng-show="orderByField == 'receive_company_email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_company_sms'; reverseSort = !reverseSort">Receive Company Sms
                            		<span>
                            			<span ng-show="orderByField == 'receive_company_sms'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_upline_email'; reverseSort = !reverseSort">Receive Upline Email
                            		<span>
                            			<span ng-show="orderByField == 'receive_upline_email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_upline_sms'; reverseSort = !reverseSort">Receive Upline Sms
                            		<span>
                            			<span ng-show="orderByField == 'receive_upline_sms'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_downline_email'; reverseSort = !reverseSort">Receive Downline Email
                            		<span>
                            			<span ng-show="orderByField == 'receive_downline_email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='receive_downline_sms'; reverseSort = !reverseSort">Receive Downline Sms
                            		<span>
                            			<span ng-show="orderByField == 'receive_downline_sms'">
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
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="profile in profiles | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage"  total-items="countItems">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.profile_id')">
	                            </td>
								
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.public_name"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.public_content"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_company_email"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_company_sms"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_upline_email"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_upline_sms"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_downline_email"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.receive_downline_sms"></span></a>
					            </td>
					            
					            <td>
					                <a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.disabled"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/profiles/@include('_helpers.profile_id')"><span ng-bind="profile.updated_at"></span></a>
					            </td>
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                @include('_helpers.loading')<div ng-controller="OtherController" class="other-controller">
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
                    profileCtrl : {
                        path : '/api/all-profiles'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/postController.js') }}
@stop