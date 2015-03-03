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
                            <a class="pull-left" href="#">
                                <img class="media-object" src="/img/media/@{{inventory.model}}.jpg" width="100">
                            </a>
                            <div class="media-body clearfix">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="media-heading pull-left">@{{inventory.model}}</h4>
                                        <div class="pull-right">
                                            <span><b>$@{{inventory.price}}</b></span>
                                        </div>
                                        <div>
                                            <br class="clearfix"/><br/>
                                            <p>@{{inventory.description|| "Click to Edit "}}&nbsp;<a href="#" editable-text="inventory.description" title="Click to edit"><i class="fa fa-edit"></i></a></p><br/>
                                        </div>
                                        <div class="row available-xs">
                                            <div class="col-md-12"><br/>
                                                <h5>Available Sizes:</h5>
                                                <div ng-switch on="inventory.doNag">
                                                    <div ng-switch-when="none-selected" class="pull-left alert alert-danger cleafix" role="alert">
                                                        <strong>Oh snap!</strong> Please select at least one size and try clicking the "add" button again.
                                                    </div>
                                                    <div ng-switch-when="volume-too-large" class="pull-left alert alert-danger cleafix" role="alert">
                                                        <strong>Sorry!</strong> We can't cater your order as we currently have a limited volume. You may want to reduce your quantity.
                                                    </div>
                                                    <div ng-switch-default></div>
                                                </div><div ng-if="inventory.doNag"><br/><br/><br/><br/></div>
                                                <ul class="nav nav-pills">
                                                    <li ng-repeat="(key,size) in inventory.sizes">
                                                        <a class="pull-left" style="padding-right: 0;padding-left: 0;display:none;" href="#">
                                                            <input ng-class="{disabled:!size.value}" style="display:none" class="bulk-check" type="checkbox" name="size_@{{k}}_@{{$index}}" ng-model="size.checked" ng-checked="size.checked" value="@{{key}}">
                                                        </a>
                                                        <span class="label label-info">@{{size.key}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
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
                <button ng-hide="next" type="button" class="pull-right btn btn-sm btn-primary" ng-click="changepasswd()">Submit</button>
                <button ng-show='next' type="button" class="pull-right btn btn-sm btn-primary" ng-click="goto('/products')">Next</button>
        </div>
    </div>
</div>
