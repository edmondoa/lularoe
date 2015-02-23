@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => '/users/email', 'method' => 'POST')) }}
	    <div ng-controller="UserController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All Users</h1>
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
		                    @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		                    	<a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('users/create') }}"><i class="fa fa-plus"></i></a>
		                    @endif
		                    <div class="pull-left">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="/users/email" selected>Send Email</option>
		                                <option value="/users/sms">Send Text (SMS)</option>
		                                <option value="users/disable">Disable</option>
		                                <option value="users/enable">Enable</option>
		                                <option value="users/delete">Delete</option>
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
                            	
                            	<!-- <th class="link" ng-click="orderByField='public_id'; reverseSort = !reverseSort">Public Id
                            		<span>
                            			<span ng-show="orderByField == 'public_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th> -->
                        		
                            	<!-- <th class="link" ng-click="orderByField='first_name'; reverseSort = !reverseSort">First Name
                            		<span>
                            			<span ng-show="orderByField == 'first_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th> -->
                        		
                            	<th class="link" ng-click="orderByField='last_name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'last_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
 
                            	<th class="link" ng-click="orderByField='id'; reverseSort = !reverseSort">ISM ID
                            		<span>
                            			<span ng-show="orderByField == 'id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='gender'; reverseSort = !reverseSort">Gender
                            		<span>
                            			<span ng-show="orderByField == 'gender'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='dob'; reverseSort = !reverseSort">DOB
                            		<span>
                            			<span ng-show="orderByField == 'dob'">
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
                        		
                            	<th class="link" ng-click="orderByField='role_id'; reverseSort = !reverseSort">Role
                            		<span>
                            			<span ng-show="orderByField == 'role_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='rank_id'; reverseSort = !reverseSort">Rank
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<!-- <th class="link" ng-click="orderByField='mobile_plan_id'; reverseSort = !reverseSort">Mobile Plan Id
                            		<span>
                            			<span ng-show="orderByField == 'mobile_plan_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th> -->
                        		
                            	<!-- <th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                            		<span>
                            			<span ng-show="orderByField == 'disabled'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th> -->
                        		
                            	<th class="link" ng-click="orderByField='front_line_count'; reverseSort = !reverseSort">Immediate Downline
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='descendant_count'; reverseSort = !reverseSort">Total Downline
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
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
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="user in users | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage" total-items="countItems">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="user_ids[]" value="@include('_helpers.user_id')">
	                            </td>
								
					            <!-- <td>
					                <span ng-bind="user.public_id"></span>
					            </td> -->
					            
					            <td>
					                <a href="/users/@include('_helpers.user_id')"><span ng-bind="user.last_name"></span>, <span ng-bind="user.first_name"></span></a>
					            </td>

					            <td>
					                <a href="/users/@include('_helpers.user_id')"><span ng-bind="user.id"></span></a>
					            </td>
					            
					            <td>
					                <span ng-bind="user.public_gender"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="user.public_dob"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="user.public_phone"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="user.role_name"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="user.rank_name"></span> (<span ng-bind="user.rank_id"></span>)
					            </td>
					            
					            <!-- <td>
					                <span ng-bind="user.mobile_plan_id"></span>
					            </td> -->
					            
					            <!-- <td>
					                <span ng-bind="user.disabled"></span>
					            </td> -->
					            
					            <td>
					            	<a href="/downline/immediate/@include('_helpers.user_id')" title="View Immediate Downline"><span ng-bind="user.front_line_count"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/downline/all/@include('_helpers.user_id')" title="View All Downline"><span ng-bind="user.descendant_count"></span></a>
					            </td>
					            
					            <td>
					            	<span ng-bind="user.updated_at"></span>
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

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function UserController($scope, $http) {
	    var defaultLimit = 10;
        
        $scope.users = [];
        $scope.currentPage = 1;
        $scope.pageSize = defaultLimit;
        $scope.countItems = 0;
        $scope.meals = [];
		
        var mUser = function(curPage,  limit){
            var path = '/api/all-users/'+curPage;
            if(limit != defaultLimit){
                path += '/'+limit;
            }
            $http.get(path).success(function(users) {
                /**/
                console.log("from net");
                console.log(users);
                console.log("scope var");
                console.log($scope.users);
                var lSize = users.data.length;
                    //for(var i =0; i< lSize; i++){
                        $scope.users = users.data.splice(0);
                        //$scope.users.push(users.data.pop());
                        console.log($scope.users);        
                    //}
                /**/
                //$scope.users = users.data;
                $scope.countItems = users.count;
                
                var totalPages = Math.ceil(users.count/limit);
                console.log("total-pages: "+ totalPages);
                console.log("users.length: "+ $scope.users.length);
                
                var tempPages = Math.ceil($scope.users.length/limit);
                console.log("tempPages:  "+tempPages);
                /**/if(tempPages < 2){/**//*totalPages){*/
                /**/    //mUser(tempPages+1, limit);
                }/**/
                
                @include('_helpers.bulk_action_checkboxes')
                
                //console.log("users");
                console.log($scope.users);
            });    
        }
		
		$scope.pageChangeHandler = function(num) {
            console.log("UserController - pageChangeHandler: " +num+" curPage: "+$scope.currentPage);    
		    
		};
	
        $scope.$watch("pageSize", function(n, o){
            if(n != o){
                mUser($scope.currentPage, n);
                console.log("pageSize changed: n["+n+"]"+" o:["+o+"]");
            }
        });
    
        $scope.$watch("currentPage", function(n, o){
            var totalPages = Math.ceil($scope.countItems/$scope.pageSize);
            var tempPages = Math.ceil($scope.users.length/$scope.pageSize);
            console.log("totalPages: "+totalPages +" tempPages: "+ tempPages);
            console.log("l: "+$scope.users.length);
            console.log("ln: "+$scope.countItems);
            console.log("users.length: "+ $scope.users.length);
            console.log($scope.users);
            
            //if(!$scope.countItems || tempPages < totalPages)
            //if($scope.countItems == 0)
            //{
                mUser(n, $scope.pageSize);
                console.log("currentPage changed: n["+n+"]"+" o:["+o+"]");
            //}
        });
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
            console.log("OtherController - pageChangeHandler: " +num+" curPage: "+$scope.currentPage);    
		};
	}
	
</script>
@stop