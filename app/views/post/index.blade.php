<?php
	if (Auth::user()) $layout = 'default';
	else $layout = 'public';
?>
@extends('layouts.' . $layout)
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'posts/disable', 'method' => 'POST')) }}
	    <div ng-controller="PostController" class="my-controller">
	    	<div class="post-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top no-bottom pull-left no-pull-xs">All Announcements</h1>
		                @if (Auth::user())
			            	<div class="pull-right hidable-xs">
			                    <div class="input-group pull-right">
			                    	<span class="input-group-addon no-width">Count</span>
			                    	<input class="form-control itemsPerPage width-auto" ng-model="postSize" type="number" min="1">
			                    </div>
			                    <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPost"></span></h4>
			            	</div>
			        	@endif
			    	</div>
		        </div><!-- row -->
		        <div class="row">
		        	@if (Auth::user())
			            <div class="col-md-6 col-sm-6 col-xs-12 post-actions-left">
			            	@if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
				                <div class="pull-left">
				                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('posts/create') }}"><i class="fa fa-plus"></i></a>
				                    <div class="pull-left">
				                        <div class="input-group">
				                            <select class="form-control selectpicker actions">
				                                <option value="posts/disable" selected>Disable</option>
				                                <option value="posts/enable">Enable</option>
				                                <option value="posts/delete">Delete</option>
				                            </select>
				                            <div class="input-group-btn no-width">
				                                <button class="btn btn-default applyAction" disabled>
				                                    <i class="fa fa-check"></i>
				                                </button>
				                            </div>
				                        </div>
				                    </div>
				                </div>
			                @endif
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
			        @else
			        	<div class="col col-md-4">
			                <div class="input-group no-pull-xs">
			                    <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
			                    <span class="input-group-btn no-width">
			                        <button class="btn btn-default" type="button">
			                            <i class="fa fa-search"></i>
			                        </button>
			                    </span>
			                </div>
			        	</div>
			        @endif
			        </div><!-- row -->
		    	</div><!-- post-actions -->
	        <div class="row">
	            <div class="col col-md-12">
	            	@if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
	                	<table class="table">
	               	@else
	               		<table class="table width-auto">
	               	@endif
	                    <thead>
	                        <tr>
	                        	
	                        	@if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
		                            <th>
		                            	<input type="checkbox">
		                            </th>
		                        @endif
                            	
                            	<th class="link" ng-click="orderByField='created_at'; reverseSort = !reverseSort">Date
                            		<span>
                            			<span ng-show="orderByField == 'created_at'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                            	
                            	<th class="link" ng-click="orderByField='title'; reverseSort = !reverseSort">Title
                            		<span>
                            			<span ng-show="orderByField == 'title'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                        		@if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
                        		
	                            	<th class="link" ng-click="orderByField='url'; reverseSort = !reverseSort">URL
	                            		<span>
	                            			<span ng-show="orderByField == 'url'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        		
	                            	<th class="link" ng-click="orderByField='public'; reverseSort = !reverseSort">Public
	                            		<span>
	                            			<span ng-show="orderByField == 'public'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        		
	                            	<th class="link" ng-click="orderByField='public'; reverseSort = !reverseSort">ISM's
	                            		<span>
	                            			<span ng-show="orderByField == 'public'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        		
	                            	<th class="link" ng-click="orderByField='public'; reverseSort = !reverseSort">Customers
	                            		<span>
	                            			<span ng-show="orderByField == 'public'">
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
	                        <tr ng-class="{ highlight : post.new == 1, semitransparent : post.disabled == 1 }" dir-paginate-start="post in posts | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: postSize" current-post="currentPost">
	                            @if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
		                            <td ng-click="checkbox()">
		                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.post_id')">
		                            </td>
		                        @endif
							
					            <td>
					            	<span ng-bind="post.formatted_date"></span>
					            </td>
								
					            <td>
					            	@if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
					            		<a href="/posts/@include('_helpers.post_id')/edit">
					            	@else
					            		<a href="/posts/@include('_helpers.post_url')">
					         		@endif
					            		<span ng-bind="post.title"></span>
					            	</a>
					            </td>
					            
					            @if (Auth::user() && Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
						            <td>
						                <span ng-bind="post.url"></span>
						            </td>
						            
						            <td>
						                 <span ng-if="post.public"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td>
						                 <span ng-if="post.reps"><i class="fa fa-check"></i></span>
						            </td>
						            
						            <td>
						                 <span ng-if="post.customers"><i class="fa fa-check"></i></span>
						            </td>
	
						            <td>
						            	<span ng-bind="post.updated_at"></span>
						            </td>
						    	@endif
						            
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                	@include('_helpers.loading')<div ng-controller="OtherController" class="other-controller">
	                    <div class="text-center">
	                        <dir-pagination-controls boundary-links="true" on-post-change="postChangeHandler(newPostNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
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
	
	function PostController($scope, $http) {
	
		$http.get('/api/all-posts').success(function(posts) {
			$scope.posts = posts;
			console.log($scope.posts);
			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$scope.currentPost = 1;
		$scope.postSize = 10;
		$scope.meals = [];
		
		$scope.postChangeHandler = function(num) {
			
		};
		
	}
	
	function OtherController($scope) {
		$scope.postChangeHandler = function(num) {
		};
	}

</script>
@stop