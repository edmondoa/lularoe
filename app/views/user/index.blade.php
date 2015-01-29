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
    app.service("shared", function($http, $q){
        var isLoading = false;
        var requestPromise = null;
        var requestData = function(url){
            isLoading = true;
            var canceller = $q.defer();

            var request = $http.get(url, { timeout: canceller.promise});
            
            var promise = request.then(
                function( response ) {
                    isLoading = false;
                    return( response.data );
                },
                function( response ) {
                    return( $q.reject( "Something went wrong" ) );
                }
            );
            
            promise.abort = function() {
                isLoading = false;
                if(canceller){
                    canceller.resolve();
                }
            };
            
            promise.finally(
                function() {
                    /*console.log( "Cleaning up object references." );*/
                    canceller = request = promise = null;
                }
            );
            
            return( promise );
            
        };

        return {
            getIsLoading: function () {
                return isLoading;
            },
            requestPromise :requestPromise,
            requestData : requestData
        };
    });
    
	function UserController($scope, $http, shared, $q, $interval) {
	    var defaultLimit = 10,
            defaultOrderField = "last_name";
        $scope.orderByField = defaultOrderField;
        $scope.users = [];
        $scope.usersData = [];
        $scope.currentPage = 1;
        $scope.pageSize = defaultLimit;
        $scope.countItems = 0;
        $scope.meals = [];
        $scope.loadedPages = [];
        $scope.stop = undefined;
        $scope.prevJump = false;
        $scope.jumpData = [];
        
        $scope.counter = 0;
        
        var mUser = function(curPage,  limit, orderByField, sequence){
            var path = '/api/all-users/'+curPage;
            path += '?a=1';
            if(limit != defaultLimit){
                path += '&l='+limit;
            }
            if(orderByField != undefined && orderByField != defaultOrderField){
                path += '&o='+orderByField;
            }
            if(sequence != undefined && sequence != 'asc'){
                path += '&s='+sequence;
            }
            
            if(shared.requestPromise && shared.getIsLoading()){
                shared.requestPromise.abort();    
            }
            shared.requestPromise = shared.requestData(path);
            var promise = shared.requestPromise.then(function(v){
                $scope.loadedPages.push(curPage);
                $scope.countItems = v.count;
                var totalPages = Math.ceil($scope.countItems/limit);
                var tempPages = Math.ceil($scope.users.length/limit);

                var res = [];
                var res = v.data.map(function(user, i){
                    var a = [],offset = (curPage -1) * limit + i;
                    a = $scope.users.filter(function(n){
                        return n.id == user.id;
                    });
                    
                    if(!a.length){
                        var i= $scope.users.length;  
                        for(;i <= offset; i++){
                            $scope.users.splice(i,0,user);
                        }    
                        
                        $scope.users.splice(offset,1,user);    
                    }

                    return user;    
                });
                
                $scope.usersData.push({'page':curPage,'data':res});
                
                @include('_helpers.bulk_action_checkboxes')
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        }
		
		$scope.pageChangeHandler = function(num) {
            
		};
        
        $scope.stopRequestPages = function() {
          if (angular.isDefined($scope.stop)) {
            $interval.cancel($scope.stop);
            $scope.stop = undefined;
          }
        };
        
        $scope.checkLoadedPages = function(curPage){
            var beenLoaded = [];
            beenLoaded = $scope.loadedPages.filter(function(n){
                return n == curPage;  
            });
            
            return !beenLoaded.length; 
        };
        
	     
        $scope.$watch("pageSize", function(n, o){
            if(n != o){
                $scope.stopRequestPages();
                var promise = mUser($scope.currentPage, n, $scope.orderByField, $scope.reverseSort);
                //console.log("pagesize currentpage: "+$scope.currentPage);
            }
        });
    
        $scope.$watch("currentPage", function(n, o){
            var totalPages = Math.ceil($scope.countItems/$scope.pageSize);
            var tempPages = Math.ceil($scope.users.length/$scope.pageSize);
            if(n!= undefined && o != undefined && n-1 != o && n != o ){
                $scope.prevJump = true;
            }
        
            if($scope.checkLoadedPages(n) && (!$scope.countItems || tempPages < totalPages))
            {
                var promise = mUser(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort);
                promise.then(function(v){
                    var totalPages = Math.ceil($scope.countItems/$scope.pageSize);
                    var curPage = n; 
                    
                    if ( angular.isDefined($scope.stop) ) {
                        return;   
                    }
                    
                    $scope.stop = $interval(function() {
                        if(!shared.getIsLoading()){
                            curPage++;
                            if($scope.prevJump){
                                curPage = 1;
                                $scope.prevJump = false;    
                            }
                            if ($scope.checkLoadedPages(curPage) && curPage <= totalPages) {
                                mUser(curPage, $scope.pageSize,$scope.orderByField,$scope.reverseSort);
                            }
                        }
                        
                        if($scope.loadedPages.length == totalPages){
                            $scope.stopRequestPages();
                        }
                        
                    }, 1);
                    /**/
                },function(r){
                    return( $q.reject( "Something went wrong" ) );
                });
            }
        });
        
        $scope.$watch("usersData.length", function(n, o){
            //console.log($scope.usersData);
        });
        
        $scope.$on('$destroy', function() {
          $scope.stopRequestPages();
        });
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
            //console.log("OtherController - pageChangeHandler: " +num+" curPage: "+$scope.currentPage);    
		};
	}
	
</script>
@stop