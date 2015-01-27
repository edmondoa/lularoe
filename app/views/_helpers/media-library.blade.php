<style>
	.selected { position:absolute; top:0; right:0; bottom:0; left:0; background:rgba(255,0,0,.5); }
	.semitransparent { opacity:.33; }
</style>
<div class="index">
    <div class="MediaController">
    	<div class="page-actions">
	        <div class="row">
	            <div class="col-md-12">
	                <div class="pull-left margin-right-2">
	                    <div class="input-group">
	                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
	                        <span class="input-group-btn no-width">
	                            <button class="btn btn-default" type="button" disabled>
	                                <i class="fa fa-search"></i>
	                            </button>
	                        </span>
	                    </div>
	                </div>
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
		                	<button type="button" class="btn btn-default" ng-click="orderByField='title'; reverseSort = !reverseSort">Name
		                		<span>
		                			<span ng-show="orderByField == 'title'">
		                    			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                    			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
		                			</span>
		                		</span>
		            		</span>
		            	</div>
                	</div>
	            	<!-- <div ng-if="media.length > 10" class="pull-right hidable-xs"> -->
		            	<div class="pull-right hidable-xs">
		                    <!-- <div class="input-group pull-right">
		                    	<span class="input-group-addon no-width">Count</span>
		                    	<input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
		                    </div> -->
		                    <h4 class="pull-right margin-right-1 no-top">Page <span ng-bind="currentPage"></span></h4>
		            	</div>
	            	<!-- </div> -->
		    	</div>
	        </div><!-- row -->
	    </div><!-- page-actions -->
	    <br>
        <div class="row">
            <div class="col col-md-12">
                <!-- <table class="table">
                    <thead>
                        <tr>
                            <th>
                            	<input type="checkbox">
                            </th>
                        </tr>
                    </thead>
                </table> -->
            	<!-- <div class="link" ng-click="orderByField='type'; reverseSort = !reverseSort">Filter by Type
            		<span>
            			<span ng-show="orderByField == 'type'">
                			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
            			</span>
            		</span>
        		</div> -->
        		<div ng-hide="val">
            		<ul class="tiles tiles-small">
	                    <li ng-click="selectMedia(media)" ng-class="{highlight: media.new == 1}" dir-paginate-start="media in mediaList | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                        <!-- <div ng-click="checkbox()"> -->
	                        	<div ng-if="canShow(media)" class="selected">
	                        		<input class="bulk-check" type="hidden" name="ids[]" value="@include('_helpers.media_id')">
	                        	</div>
	                        	<div class="options" ng-show="media.showOptions">
		                        	<a target="_blank" href="/uploads/@include('_helpers.media_url')"><i class="fa fa-eye"></i></a>
		                        	<a href="/media/@include('_helpers.media_id')"><i class="fa fa-info"></i></a>
		                        	@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) || (isset($user_id) && $user_id == Auth::user()->id))
		                        		<a href="/media/@include('_helpers.media_id')/edit"><i class="fa fa-pencil"></i></a>
		                        	@endif
		                        	<a href="/uploads/@include('_helpers.media_url')" download="/uploads/@include('_helpers.media_url')"><i class="fa fa-download"></i></a>
	                        	</div>
	                        	<?php // image ?>
	                        	<img title="@include('_helpers.media_title')" ng-if="media.type == 'Image'" ng-class="{semitransparent : media.disabled}" src="/uploads/@include('_helpers.media_url')">
	                        	<div class="file" ng-if="media.type != 'Image'">
	                        		<i ng-if="media.type == 'Database'" class="fa fa-database" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Document'" class="fa fa-file-word-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Image file'" class="fa fa-image" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Text'" class="fa fa-file-text-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Spreadsheet'" class="fa fa-file-excel-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Audio'" class="fa fa-file-audio-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Video'" class="fa fa-file-video-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Code'" class="fa fa-file-code-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'File'" class="fa fa-file-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'PDF'" class="fa fa-file-pdf-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Presentation'" class="fa fa-file-powerpoint-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<i ng-if="media.type == 'Archive'" class="fa fa-file-archive-o" ng-class="{semitransparent : media.disabled}"></i>
	                        		<br>
	                        		<div ng-class="{semitransparent : media.disabled}" class="file-title" ng-bind="media.title"></div>
	                        	</div>
	                        <!-- </div> -->
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
    </div><!-- app -->
@section('scripts3')
	<script>
	
		var app = angular.module('app', ['angularUtils.directives.dirPagination']);
		
		function MediaController($scope, $http) {
		
			<?php
				if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) $id = 0;
				else $id = Auth::user()->id;
			?>
			
			$http.get('/api/images-by-user/{{ $id }}').success(function(media) {
	
				$scope.mediaList = media;
				
				// insert image
				$scope.chooseImage = function() {
					$('.mce-combobox.mce-last.mce-abs-layout-item .mce-textbox').attr('value', '/uploads/' + shownMedia.url);
				}
	
				// hide if object empty
				$scope.val = "";
				
				// download file
				$scope.download = function(url) {
					window.location.href = '/uploads/' + url;
				}
				
				@include('_helpers.bulk_action_checkboxes')
				
			  var shownMedia; //Set you default media
			
			  $scope.selectMedia = function(media) {
			    shownMedia = media; //on click, set the new media as selected media
			  }
			
			  $scope.canShow = function(media) {
			    return angular.equals(shownMedia, media); //Check if this is the displayed media
			  }
				
				$scope.currentPage = 1;
				$scope.pageSize = 20;
				$scope.meals = [];
				
			});
			
			$scope.pageChangeHandler = function(num) {
				
			};
			
		}
		
		function OtherController($scope) {
			$scope.pageChangeHandler = function(num) {
			};
		}
	
	</script>
@stop