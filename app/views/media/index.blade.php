@extends('layouts.default')
@section('style')
	<style>
		.selected { position:absolute; top:0; right:0; bottom:0; left:0; background:rgba(255,0,0,.5); }
		.semitransparent { opacity:.33; }
	</style>
@stop
@section('content')
<div ng-app="app" class="index">
	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
    	{{ Form::open(array('url' => 'media/disable', 'method' => 'POST')) }}
    @else
    	{{ Form::open(array('url' => 'media/delete', 'method' => 'POST')) }}
    @endif
    	<div ng-controller="MediaController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">
		                	@if (isset($user->id))
		                		@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) && Auth::user()->id != $user->id || (Auth::user()->id == 0 && $user->id == 0))
		                			{{ $user->full_name }}'s Resources
		                		@else
		                			My Resources
		                		@endif
		                	@elseif (isset($reps))
		                		Rep Resources
		                	@elseif (isset($shared_with_reps))
		                		Resources Shared with Reps
		                	@else
		                		Resource Library
		                	@endif
		                </h1>
		            	<div ng-if="media.length > 10" class="pull-right hidable-xs">
		                    <div class="input-group pull-right">
		                    	<span class="input-group-addon no-width">Count</span>
		                    	<input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
		                    </div>
		                    <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
		            	</div>
			    	</div>
		        </div><!-- row -->
		        <div class="row">
		    		<div class="col-sm-8 col-xs-12 page-actions-left">
		                <div class="pull-left">
		                	@if ((isset($user->id) && Auth::user()->id == $user->id) || Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
			                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('media/create') }}"><i class="fa fa-upload"></i></a>
			                    <div class="pull-left">
			                        <div class="input-group pull-left margin-right-2">
			                            <select class="form-control selectpicker actions">
				                            <option value="/media/delete">Delete</option>
			                            	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
				                                <option value="/media/disable" selected>Disable</option>
			                                	<option value="/media/enable">Enable</option>
				                            @endif
			                            </select>
			                            <div class="input-group-btn no-width">
			                                <button class="btn btn-default">
			                                    <i class="fa fa-check"></i>
			                                </button>
			                            </div>
			                        </div>
			                    </div>
			                @endif
	                        <?php /* select categories */ ?>
	                        <div class="pull-left margin-right-1">
	                            <select ng-model="search.$" id="categories" class="form-control">
	                            	<option value="">All file types</option>
	                            	<option value="@include('_helpers.media_count_type')" ng-if="count.count > 0" ng-repeat="count in media_counts">@include('_helpers.media_count_type')s (@include('_helpers.media_count_count'))</span></option>
	                            </select>
	                    	</div>
	                        <?php /* filter and sort files */ ?>
	                        <div class="pull-left">
	                        	<div class="btn-group">
				                	<button type="button" class="btn btn-default active" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Date
				                		<span>
				                			<span ng-show="orderByField == 'updated_at'">
				                    			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
				                    			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
				                			</span>
				                		</span>
				            		</span>
				                	<button type="button" class="btn btn-default" ng-click="orderByField='type'; reverseSort = !reverseSort">Type
				                		<span>
				                			<span ng-show="orderByField == 'type'">
				                    			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
				                    			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
				                			</span>
				                		</span>
				            		</span>
				                	<button type="button" class="btn btn-default" ng-click="orderByField='title'; reverseSort = !reverseSort">Name
				                		<span>
				                			<span ng-show="orderByField == 'title'">
				                    			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
				                    			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
				                			</span>
				                		</span>
				            		</span>
				            	</div>
	                        	
	                            <!-- <select ng-model="sort" class="form-control">
									<option class="link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Date Modified
			                			<span ng-show="orderByField == 'updated_at'">
			                    			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
			                    			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
			                			</span>
					            	</option>
	                            </select> -->
	                    	</div>
		                </div>
		        	</div>
		        	<div class="col-sm-4 col-xs-12">
		                <div class="pull-right">
		                    <div class="input-group">
		                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                        <span class="input-group-btn no-width">
		                            <button class="btn btn-default" type="button" disabled>
		                                <i class="fa fa-search"></i>
		                            </button>
		                        </span>
		                    </div>
		                </div>
		            </div><!-- col -->
		        </div><!-- row -->
		    </div><!-- page-actions -->
		    <br>
	        <div class="row">
	            <div class="col col-md-12">
            		<div ng-hide="val">
	            		<ul class="tiles">
		                    <li ng-click="show=!show; hoverOn(media)" ng-mouseenter="hoverOn(media)" ng-mouseleave="hoverOff(media)" ng-class="{highlight: address.new == 1}" dir-paginate-start="media in media | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
		                        <div ng-click="checkbox()">
		                        	<div class="options" ng-show="media.showOptions" ng-mouseenter="hoverOn(media)">
			                        	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (isset($user->id) && $user->id == Auth::user()->id))
										    <form action="/media/@include('_helpers.media_id')'" method="DELETE" onsubmit="return confirm('Are you sure you want to delete this file? This cannot be undone.')">
										    	<button class="form-link pull-left"><i class="fa fa-trash" title="Delete"></i></button>
										    </form>
										@endif
			                        	<a target="_blank" href="/uploads/@include('_helpers.media_url')"><i class="fa fa-eye"></i></a>
			                        	<a href="/media/@include('_helpers.media_id')"><i class="fa fa-info"></i></a>
			                        	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (isset($user->id) && $user->id == Auth::user()->id))
			                        		<a href="/media/@include('_helpers.media_id')/edit"><i class="fa fa-pencil"></i></a>
			                        	@endif
			                        	<a href="/uploads/@include('_helpers.media_url')" download="/uploads/@include('_helpers.media_url')"><i class="fa fa-download"></i></a>
		                        	</div>
		                        	@if (!isset($user->id) && !isset($shared_with_reps) && (!isset($user->id) && !Auth::user()->hasRole(['Rep'])))
			                        	<div class="owner" ng-show="media.showOptions">
				                        	<a href="/media/user/@include('_helpers.media_user_id')"><i class="fa fa-user"></i> <span ng-bind="media.owner"></span></a>
			                        	</div>
			                        @endif
		                        	<div ng-if="show" class="selected" ng-mouseenter="hoverOn(media)" ng-mouseleave="hoverOff(media)">
		                        		<input class="bulk-check" type="hidden" name="ids[]" value="@include('_helpers.media_id')">
		                        	</div>
		                        	<?php // image ?>
		                        	<img title="@include('_helpers.media_title')" ng-if="media.type == 'Image'" ng-class="{semitransparent : media.disabled == 1}" src="/uploads/@include('_helpers.media_image_sm')">
		                        	<div class="file" ng-if="media.type != 'Image'">
		                        		<i ng-if="media.type == 'Database'" class="fa fa-database" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Document'" class="fa fa-file-word-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Image file'" class="fa fa-image" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Text'" class="fa fa-file-text-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Spreadsheet'" class="fa fa-file-excel-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Audio'" class="fa fa-file-audio-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Video'" class="fa fa-file-video-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Code'" class="fa fa-file-code-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'File'" class="fa fa-file-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'PDF'" class="fa fa-file-pdf-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Presentation'" class="fa fa-file-powerpoint-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<i ng-if="media.type == 'Archive'" class="fa fa-file-archive-o" ng-class="{semitransparent : media.disabled == 1}"></i>
		                        		<br>
		                        		<div ng-class="{semitransparent : media.disabled == 1}" class="file-title" ng-bind="media.title"></div>
		                        	</div>
		                        </div>
		                    </li>
		                    <li dir-paginate-end></li>
	            		</ul>
		                @include('_helpers.loading')
		            </div>
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
	
	function MediaController($scope, $http) {
	
		<?php
			if (isset($user->id)) {
				$media_url = '/api/media-by-user/' . $user->id;
				$count_url = '/api/media-counts/' . $user->id;
			}
			elseif (isset($reps)) {
				$media_url = '/api/media-by-reps';
				$count_url = '/api/media-counts/reps';
			}
			elseif (isset($shared_with_reps)) {
				$media_url = '/api/media-shared-with-reps';
				$count_url = '/api/media-counts/shared-with-reps';
			}
			else {
				$media_url = '/api/all-media';
				$count_url = '/api/media-counts/all';
			}
		?>
		
		$http.get('{{ $media_url }}').success(function(media) {
			$scope.media = media;
			// hide if object empty
			$scope.val = "";

			// Shows/hides the options on hover
			$scope.hoverOn = function(media) {
				return media.showOptions = true;
			};
			$scope.hoverOff = function(media) {
				return media.showOptions = false;
			};
			
			// download file
			$scope.download = function(url) {
				window.location.href = '/uploads/' + url;
			}
			
			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$http.get('{{ $count_url }}').success(function(media_counts) {
			$scope.media_counts = media_counts;
		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 100;
		$scope.meals = [];
		
		$scope.pageChangeHandler = function(num) {
			
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

	// toggle sort buttons
	$('.btn-group .btn').click(function() {
		$(this).parent().children('.btn').removeClass('active');
		$(this).addClass('active');
	});

</script>
@stop