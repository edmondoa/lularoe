@extends('layouts.default')
@section('style')
	<style>
		.selected { position:absolute; top:0; right:0; bottom:0; left:0; background:rgba(255,0,0,.5); }
		.semitransparent { opacity:.33; }
	</style>
@stop
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'attachments/disable', 'method' => 'POST')) }}
	    <div ng-controller="AttachmentController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">Media Library</h1>
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
			                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('attachments/create') }}"><i class="fa fa-plus"></i></a>
			                    <div class="pull-left">
			                        <div class="input-group">
			                            <select class="form-control selectpicker actions">
			                                <option value="attachments/disable" selected>Disable</option>
			                                <option value="attachments/enable">Enable</option>
			                                <option value="attachments/delete">Delete</option>
			                            </select>
			                            <div class="input-group-btn no-width">
			                                <button class="btn btn-default">
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
            		<ul class="tiles">
	                    <li ng-click="show=!show" ng-mouseover="showOptions()" ng-mouseleave="hideOptions()" ng-class="{highlight: address.new == 1}" dir-paginate-start="attachment in attachments | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                        <div ng-click="checkbox()">
	                        	<div ng-if="show" class="selected">
	                        		<input class="bulk-check" type="hidden" name="ids[]" value="@include('_helpers.attachment_id')">
	                        	</div>
	                        	<div class="options">
		                        	<a target="_blank" href="/uploads/@include('_helpers.attachment_url')"><i class="fa fa-eye"></i></a>
		                        	<a href="/attachments/@include('_helpers.attachment_id')"><i class="fa fa-info"></i></a>
	                        	</div>
	                        	<?php // image ?>
	                        	<img ng-if="attachment.type == 'Image'" ng-class="{semitransparent : attachment.disabled}" src="/uploads/@include('_helpers.attachment_url')">
	                        	<?php // document ?>
	                        	<div class="file" ng-if="attachment.type == 'Document'">
	                        		<i class="fa fa-file-word-o" ng-class="{semitransparent : attachment.disabled}"></i>
	                        		<br>
	                        		<div ng-if="attachment.title" class="file-title" ng-bind="attachment.title"></div>
	                        		<div ng-if="!attachment.title" class="file-title">Untitled Document</div>
	                        	</div>
	                        	<?php // database ?>
	                        	<div class="file" ng-if="attachment.type == 'Database'">
	                        		<i class="fa fa-database" ng-class="{semitransparent : attachment.disabled}"></i>
	                        		<br>
	                        		<div ng-if="attachment.title" class="file-title" ng-bind="attachment.title"></div>
	                        		<div ng-if="!attachment.title" class="file-title">Untitled Database</div>
	                        	</div>
	                        	<?php // image file ?>
	                        	<div class="file" ng-if="attachment.type == 'Image file'">
	                        		<i class="fa fa-image" ng-class="{semitransparent : attachment.disabled}"></i>
	                        		<br>
	                        		<div ng-if="attachment.title" class="file-title" ng-bind="attachment.title"></div>
	                        		<div ng-if="!attachment.title" class="file-title">Untitled Image File</div>
	                        	</div>
	                        </div>
	                    </li>
	                    <li dir-paginate-end></li>
            		</ul>
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
	
	function AttachmentController($scope, $http) {
	
		$http.get('/api/all-attachments').success(function(attachments) {
			$scope.attachments = attachments;

			// show options
			$scope.hideOptions = function() {
				$('.tiles li').hover(function() {
					$('.options', this).show();
				});
			}
			
			// hide options
			$scope.showOptions = function() {
				$('.tiles li').hover(function() {
					$('.options', this).hide();
				});
			}
			
			@include('_helpers.bulk_action_checkboxes')
			
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

</script>
@stop