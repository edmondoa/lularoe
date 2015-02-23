@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
	{{ Form::open(array('url' => '/site_configs/email', 'method' => 'POST')) }}
		<div ng-controller="SiteConfigController" class="my-controller">
			<div class="page-actions">
				<div class="row">
					<div class="col col-md-12">
						<h1 class="no-top">Site Settings</h1>
					</div>
				</div><!-- row -->
			</div><!-- page-actions -->
			<div class="row">
				<div class="col col-md-12">
					<table class="table width-auto">
						<thead>
							<tr>
								<th class="link" ng-click="orderByField='key'; reverseSort = !reverseSort">Name
									<span>
										<span ng-show="orderByField == 'key'">
											<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
											<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
										</span>
									</span>
								</th>
								<th class="link" ng-click="orderByField='value'; reverseSort = !reverseSort">Value
									<span>
										<span ng-show="orderByField == 'value'">
											<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
											<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
										</span>
									</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-class="{highlight: address.new == 1}" dir-paginate-start="site_config in site_configs | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage" total-items="countItems">
								<td>
									<a href="/config/@{{site_config.id}}/edit"><span ng-bind="site_config.key"></span>
								</td>
								
								<td>
									<span ng-bind="site_config.value"></span>
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
    angular.extend(ControlPad, (function(){                
                return {
                    siteConfigCtrl : {
                        path : '/api/all-config'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/siteConfigController.js') }}
@stop