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
                            <a ng-click="addProduct()" class="btn btn-primary pull-left margin-right-1" title="Add Products" href="javascript:void(0);"><i class="fa fa-plus"></i> ADD PRODUCT</a>
                        </div>
                        <div class="input-group pull-right no-pull-xs width-xs">
                        </div>
                    </div>
                    @include('_helpers.loading')
                    <ul class="media-list" id="currentinventory">
                        <li class="media" dir-paginate-start="product in products | filter:search | itemsPerPage: pageSize " current-page="currentPage" total-items="countItems">
                            <form editable-form name="editableForm" onaftersave="saveProduct($data)">
								<div class="panel panel-primary">
                                    <div class="panel-header">
                                        <div class="form-group pull-right">
                                            <a ng-click="editableForm.$show()" ng-show="!editableForm.$visible" class="btn btn-primary form-control" title="Edit Product" href="javascript:void(0);"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
										    <div class="col-md-4">
											    <div class="form-group">
												    {{ Form::label('name', 'Name') }}
                                                    <div editable-text="user.name" e-name="name" e-required>@{{ user.name || 'empty' }}</div>
											    </div>
										    </div>
			                                
										    <div class="col-md-2">
											    <div class="form-group">
												    {{ Form::label('size', 'Size') }}
												    <div editable-text="product.size" e-name="size" e-required>@{{ product.size || 'empty' }}</div>
											    </div>
										    </div>
										    <div class="col-md-2">
											    <div class="form-group">
												    {{ Form::label('quantity', 'Quantity') }}
												    <div editable-number="product.quantity" e-min="1" e-name="quantity" e-required>@{{ product.quantity || 'empty' }}</div>
											    </div>
										    </div>
										    <div class="col-md-2">
											    <div class="form-group">
												    {{ Form::label('rep_price', 'Price') }}
												    <div editable-text="product.price" e-min="1" e-name="rep_price" onbeforesave="productForm.checkprice($data)" e-required>@{{ product.price || 'empty' }}</div>
											    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="pull-right">&nbsp;</span>
                                            <span class="pull-right" ng-show="editableForm.$visible">
                                                <button type="submit" class="btn btn-info" ng-disabled="editableForm.$waiting">
                                                    <i class="fa fa-save"></i> Save
                                                </button>
                                                <button type="button" class="btn btn-success" ng-disabled="editableForm.$waiting" ng-click="editableForm.$cancel()">
                                                    <i class="fa fa-close"></i> Cancel
                                                </button>
                                            </span>
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
                                
                             </form>
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
            
            <div class="clearfix pull-left">
                <span ng-if="checkProductMsg() && !productForm.status" class="well alert alert-success">@{{productForm.message}}</span>
                <span ng-if="checkProductMsg()  && productForm.status" class="well alert alert-danger">@{{productForm.message}}</span>
            </div>
			<a ng-if="!checkProductMsg()" ng-click="addProduct()" class="btn btn-primary pull-left margin-left-1" title="Add Products" href="javascript:void(0);"><i class="fa fa-plus"></i> ADD MORE</a>
			<button type="button" class="pull-right btn btn-sm btn-success" ng-click="goto('/bankinfo')">Next</button>
        </div>
    </div>
</div>
