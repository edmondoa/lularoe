<div class="row onboarding">
    <div class="col-12">
        <center>
            <h2>Hello there, {{$user->first_name}}!</h2>
            <p class="onboarding">It's now time to add the products you have with you.<br/>
            </p>
        </center>
        <div class="row">
            <div class="col-md-8 col-lg-offset-2">
                    <div class="clearfix">
                        <h3 class="pull-left no-pull-xs">Added Products</h3>
                        <div class="pull-right">
                            <a ng-click="addProduct()" class="btn btn-primary pull-left margin-right-1" title="Add Products" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                        </div>
                        <div class="input-group pull-right no-pull-xs width-xs">
                            <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
                            <span class="input-group-btn no-width">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    @include('_helpers.loading')
                    <ul class="media-list" id="currentinventory">
                        <li class="media" dir-paginate-start="inventory in inventories | filter:search | itemsPerPage: pageSize " current-page="currentPage" total-items="countItems">
                            <div class="media-body clearfix">
                                <div class="row">
                                    <div class="col-md-12">

										<div class="row well">
											<div class="col-md-6">
												<div class="form-group">
													{{ Form::label('name', 'Name') }}
													{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
												</div>
											</div>
				
											<div class="col-md-2">
												<div class="form-group">
													{{ Form::label('size', 'Size') }}
													{{ Form::text('size', null, array('class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													{{ Form::label('quantity', 'Quantity') }}
													{{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													{{ Form::label('rep_price', 'Price') }}
													<div class="input-group">
														<span class="input-group-addon">$</span>
														{{ Form::text('rep_price', Input::old('rep_price'), array('class' => 'form-control')) }}
													</div>
												</div>
											</div>
								
										</div>
<!--

										<div class="row">
											<input type="hidden" name="category_id" value="0">
											<div class="col-md-3">
												<div class="form-group">
													{{ Form::label('make', 'Make') }}
													{{ Form::text('make', null, array('class' => 'form-control')) }}
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													{{ Form::label('model', 'Model') }}
													{{ Form::text('model', null, array('class' => 'form-control')) }}
												</div>
											</div>
										</div>
-->
<!----------- END -->
                                    </div>
                                </div>
                            </div>
                            <hr style="border-top: 1px solid rgba(0,0,0,0.1);"/>
                        </li>
                        <li dir-paginate-end></li>
                    </ul>
            </div>
        </div>
    </div>
</div>
<div class="onboarding_form">
    <div class="row">
        <div class="col col-xl-3 col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <button ng-hide='next' type="button" class="pull-right btn btn-sm btn-primary" ng-click="goto('/products')">Next</button>
        </div>
    </div>
</div>
