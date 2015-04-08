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
		                	@if (isset($filter))
		                		{{ $filter }}
		                	@elseif (isset($user->id))
		                		@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) && Auth::user()->id != $user->id || (Auth::user()->id == 0 && $user->id == 0))
		                			{{ $user->full_name }}'s Tools/Assets
		                		@else
		                			My Tools/Assets
		                		@endif
		                	@elseif (isset($reps))
		                		Rep Tools/Assets
		                	@elseif (isset($shared_with_reps))
		                		@if (Auth::user()->hasRole(['Rep']))
		                			Tool/Asset Library
		                		@else
		                			Tools/Assets Shared with Reps
		                		@endif
		                	@else
		                		Tools/Assets Library
		                	@endif
		                </h1>
		            	<!-- <div ng-if="media.length > 10" class="pull-right hidable-xs">
		                    <div class="input-group pull-right">
		                    	<span class="input-group-addon no-width">Count</span>
		                    	<input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
		                    </div>
		                    <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
		            	</div> -->
			    	</div>
		        </div><!-- row -->
		        <div class="row">
		    		<div class="col-md-9 col-sm-8 col-xs-12 page-actions-left">
		    			@if ((isset($user->id) && Auth::user()->id == $user->id) || Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
		                	<div class="panel panel-default pull-left margin-right-1">
		                		<div class="panel-heading">
		                			<h3 class="panel-title">Actions</h3>
		                		</div>
		                		<div class="panel-body">
					                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('media/create') }}"><i class="fa fa-upload"></i></a>
					                    <div class="pull-left">
					                    	<button type="button" ng-click="selectAll()" class="btn btn-default pull-left margin-right-1">Select All</button>
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
		                		</div>
		                	</div><!-- panel -->
	                	@endif
	                	<div class="panel panel-default pull-left">
	                		<div class="panel-heading">
	                			<h3 class="panel-title">Filters</h3>
	                		</div>
	                		<div class="panel-body">
		                        <?php /* select file types */ ?>
		                        <div class="pull-left margin-right-1">
		                            <select ng-model="search.$" id="categories" class="form-control">
		                            	<option value="">All file types</option>
		                            	<option value="@{{count.type}}" ng-if="count.count > 0" ng-repeat="count in media_counts">@{{count.type}}s (@{{count.count}})</span></option>
		                            </select>
		                    	</div>
		                        <?php /* select tags */ ?>
		                        <div class="pull-left margin-right-1">
		                            <select ng-model="search.$" id="tags" class="form-control">
		                            	<option value="">All tags</option>
		                            	<option value="@{{tag.name}}" ng-if="tag.count > 0" ng-repeat="tag in tags">@{{tag.name}} (@{{tag.count}})</span></option>
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
		                    	</div><!-- pull-left -->
		                	</div><!-- panel-body -->
		                </div><!-- panel -->
		     	 	</div><!-- col -->
		        	<div class="col-md-3 col-sm-4 col-xs-12">
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
		                    <li ng-click="media.selected=!media.selected; hoverOn(media)" ng-mouseenter="hoverOn(media)" ng-mouseleave="hoverOff(media)" ng-class="{highlight: address.new == 1}" ng-repeat="media in (filteredMedia = (media | filter:search | filter:filter | orderBy: '-updated_at' | orderBy:orderByField:reverseSort ))">
		                        <div ng-click="checkbox()">
		                        	<div class="options" ng-click="$event.stopPropagation();" ng-show="media.showOptions" ng-mouseenter="hoverOn(media)">
			                        	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (isset($user->id) && $user->id == Auth::user()->id))
										    <!-- <span class="form-link pull-left"><i class="fa fa-trash" title="Delete" ng-click="$event.stopPropagation(); deleteFile(media.id)"></i></span> -->
										@endif
			                        	<i class="link fa fa-eye" ng-click="viewFile(media.id, $index)"></i>
			                        	<!-- <a href="/media/@include('_helpers.media_id')"><i class="fa fa-info"></i></a> -->
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
		                        	<div ng-if="media.selected == true" class="selected" ng-mouseenter="hoverOn(media)" ng-mouseleave="hoverOff(media)">
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
		                    <!-- <li dir-paginate-end></li> -->
	            		</ul>
		                @include('_helpers.loading')
		            </div>
	                <!-- <div ng-controller="OtherController" class="other-controller">
	                    <div class="text-center">
	                        <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
	                    </div>
	                </div> -->
	            </div><!-- col -->
	        </div><!-- row -->
        {{ Form::close() }}
		<div id="modal" class="modal fade align-center" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-lg align-left inline-block" style="width:auto !important; max-width:90%;">
		        <div class="modal-content">
		        	<div class="modal-body overflow-hidden">
						<div id="ajax-content"></div>
		        	</div>
		        </div><!-- modal-content -->
		    </div><!-- modal-dialog -->
		</div>
    </div><!-- app -->
@stop
@section('scripts')
<script>

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function MediaController($scope, $http) {
	
		<?php
			if (isset($user->id)) {
				$media_url = '/api/media-by-user/' . $user->id;
				$file_count_url = '/api/media-counts/' . $user->id;
			}
			elseif (isset($reps)) {
				$media_url = '/api/media-by-reps';
				$file_count_url = '/api/media-counts/reps';
			}
			elseif (isset($shared_with_reps)) {
				$media_url = '/api/media-shared-with-reps';
				$file_count_url = '/api/media-counts/shared-with-reps';
			}
			else {
				$media_url = '/api/all-media';
				$file_count_url = '/api/media-counts/all';
			}
		?>
		
		$http.get('{{ $media_url }}').success(function(media) {
			
			$scope.media = media;
			$scope.filteredMedia = $scope.media;
			
			// get filter
			@if (isset($filter))
				$scope.filter = '{{ $filter }}';
			@endif
						
			// hide if object empty
			$scope.val = "";

			// Shows/hides the options on hover
			$scope.hoverOn = function(media) {
				return media.showOptions = true;
			};
			$scope.hoverOff = function(media) {
				return media.showOptions = false;
			};
			
			// select all
			$scope.selectAll = function() {
				
				// determine whether to select all or unselect all
				angular.forEach($scope.media, function(media) {
					if (media.selected == undefined || media.selected == false) {
						select_all = true;
					}
					else select_all = false;
				});
				
				// select all
				if (select_all == true) {
					angular.forEach($scope.media, function(media) {
						media.selected = true;
					});
				}
				
				// unselect all
				else {
					angular.forEach($scope.media, function(media) {
						media.selected = false;
					});
				}

			}
			
			// view file
			$scope.showing_index = null;
			$scope.viewFile = function(id, $index) {
				
				$http.get('/media/ajax/' + id).success(function(data) {
					$('#modal #ajax-content').html(data);
					$('#modal').modal('toggle');
					$scope.showing_index = $index;
					console.log($scope.showing_index);
				});
			}
			
			// download file
			$scope.download = function(url) {
				window.location.href = '/uploads/' + url;
			}
			
			// delete file
			$scope.deleteFile = function(id) {
				setTimeout(function() {
					// throw new Error("my error message");
					confirm = confirm('Are you sure you want to delete this file?');
					if (confirm == true) {
						$http.get('/media/destroy/' + id).success(function() {
							$scope.media.splice($scope.media[id], 1);
							$scope.media_counts --;
						});
					}
				}, 1);
			}

			// change file
			$('body').on('click', '.changeFile', function() {
				console.log($scope.filteredMedia);
				$scope.length = $scope.filteredMedia.length - 1;
				$('.changeFileButtons').after('<img src="/img/loading.gif">');
				var direction = $(this).attr('data-direction');
				if (direction == 'forward') {
					if ($scope.showing_index + 1 <= $scope.length) $scope.showing_index ++;
					else $scope.showing_index = 0;
				}
				else {
					if ($scope.showing_index - 1 >= 0) $scope.showing_index --;
					else $scope.showing_index = $scope.length;
				}
				id = $scope.filteredMedia[$scope.showing_index].id;
				$http.get('/media/ajax/' + id).success(function(data) {
					$('#modal #ajax-content').fadeOut(function() {
						$(this).html(data).fadeIn();
					});	
				});
			});
			
			// count tags
			$http.get('/api/media-tags').success(function(media_tags) {
				angular.forEach(media_tags, function(media_tag) {
					angular.forEach($scope.media, function(media) {
						angular.forEach(media.tags, function(tag) {
							if (media_tag.name == tag.name) {
								media_tag.count ++;
							} 
						});
					});
				});
				$scope.tags = media_tags;
				
				// filter results and tags for current category being viewed
				@if (isset($filter))
					if ($scope.filter != '') {
						tags_of_filtered_files = [];
						filtered_files = [];
						angular.forEach($scope.media, function(file) {
							angular.forEach(file.tags, function(tag) {
								if (tag.name === $scope.filter) {
									angular.forEach(file.tags, function(tag_to_add) {
										tags_of_filtered_files.push(tag_to_add);
									});
									filtered_files.push(file);
								}
							});
						});
						$scope.tags = [];
						angular.forEach(media_tags, function(tag) {
							angular.forEach(tags_of_filtered_files, function(tag_of_filtered_file) {
								if (tag_of_filtered_file.name === tag.name) $scope.tags.push(tag_of_filtered_file);
							});
						});
						grouped_tags = [];
						angular.forEach($scope.tags, function(tag) {
							var in_array = false;
							angular.forEach(grouped_tags, function(grouped_tag, key) {
								if (grouped_tag.name == tag.name) {
									in_array = true;
									grouped_tags[key].count += 1;
								}
							});
							if (in_array == false) {
								tag.count = 1;
								grouped_tags.push(tag);
							}
						});
						$scope.tags = grouped_tags;
						
						// filter media counts for category being viewed
						filtered_file_types = [];
						angular.forEach(filtered_files, function(file) {
							var in_array = false;
							angular.forEach(filtered_file_types, function(filtered_file_type, key) {
								if (file.name == filtered_file_type.name) {
									in_array = true;
									filtered_file_types[key].count += 1;
								}
							});
							if (in_array == false) {
								var filtered_file_type = {
									type: file.type,
									count: 1
								};
								filtered_file_types.push(filtered_file_type);
							}
						});
						$scope.media_counts = filtered_file_types;
					}
				@endif
			});

			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$http.get('{{ $file_count_url }}').success(function(data) {
			$scope.media_counts = data;
		});
		
		// $scope.currentPage = 1;
		// $scope.pageSize = 100;
		
		// $scope.pageChangeHandler = function(num) {
// 			
		// };
		
	}
	
	// function OtherController($scope) {
		// $scope.pageChangeHandler = function(num) {
		// };
	// }

	// toggle sort buttons
	$('.btn-group .btn').click(function() {
		$(this).parent().children('.btn').removeClass('active');
		$(this).addClass('active');
	});

</script>
@stop