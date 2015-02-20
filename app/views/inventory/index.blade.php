@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'inventories/checkout', 'method' => 'POST')) }}
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-md-8">
                    <div class="clearfix">
                        <h1 class="pull-left">Current Inventory</h1>
                        <div class="input-group pull-right no-pull-xs">
                            <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
                            <span class="input-group-btn no-width">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <ul class="media-list" id="currentinventory">
                        <li class="media" dir-paginate-start="inventory in inventories | filter:search | itemsPerPage: pageSize " current-page="currentPage" total-items="countItems">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="/img/media/@{{inventory.model}}.jpg" width="100">
                            </a>
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="media-heading pull-left">@{{inventory.itemnumber}}</h4>
                                        <div class="pull-right">
                                            <span><b>$@{{inventory.price}}</b></span>
                                        </div>
                                        <br class="clearfix"/><br/>
                                        <p>Nothing to descript</p><br/>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="pull-right hidable-xs">
                                            <div class="input-group pull-right">
                                                <span class="input-group-addon no-width">Quantity</span>
                                                <input class="form-control itemsPerPage width-auto" ng-model="inventory.numOrder" type="number" min="1" placeholder="1">
                                            </div>
                                            <div class="input-group pull-right">
                                                <button class="pull-right btn btn-sm btn-info" ng-click="addOrder(inventory)" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
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
                                                <a class="pull-left" style="padding-right: 0;padding-left: 0;" href="#">
                                                    <input ng-class="{disabled:!size.value}" class="bulk-check" type="checkbox" name="size_@{{k}}_@{{$index}}" ng-model="size.checked" ng-checked="size.checked" value="@{{key}}">
                                                </a>
                                                <a ng-click="toggleCheck(inventory,size)" class="pull-left" href="#"><span>@{{size.key}} - @{{size.value}} - </span>
                                                    <span ng-if="size.value > 1000" class="label label-info">IN STOCK</span>
                                                    <span ng-if="size.value < 1000 && size >= 500" class="label label-warning">LIMITED STOCK</span>
                                                    <span ng-if="size.value < 500 && size.value != 0" class="label label-danger">HURRY</span>
                                                    <span ng-if="size.value == 0" class="label label-default">OUT OF STOCK</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-top: 1px solid rgba(0,0,0,0.1);"/>
                        </li>
                        <li dir-paginate-end></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h3>Order Total</h3>
                    <div class="well">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right">$@{{subtotal()|number:2}}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td align="right">$@{{tax|number:2}}</td>
                                </tr>
                                <tr>
                                    <td><label>Total</label></td>
                                    <td align="right">$@{{total|number:2}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" class="pull-right btn btn-sm btn-success">Checkout</button>
                                        <button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
                                    </td>
                            </tbody>
                        </table>
                    </div>
                    <h3>Selected Items<span ng-if="countSelect()"> : @{{orders.length}}</span></h3>
                    <div ng-if="isEmpty()">
                        <ul class="media-list">
                            <li class="media">
                                <div class="well">
                                    <div class="row">
                                        <div class="col-lg-12">empty</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="media-list">
                            <li class="media">
                                <div class="well clearfix" ng-repeat="(idx,order) in orders | orderBy: 'itemnumber'">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span class="label label-info">$@{{order.price}} / @{{order.size}}</span>
                                            <img src="/img/media/@{{inventory.model}}.jpg" width="50" />
                                            <div style="width:80px">
                                                <span class="btn btn-xs btn-success" ng-click="plus(order)">+</span>
                                                <span class="btn btn-xs btn-danger" ng-click="minus(order)">-</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <h4 class="media-heading"> @{{order.model}} - @{{order.size}}</h4>
                                            <p class="">Some semblance of a description could go here</p>
                                            <div class="media-body">
                                                <div class="col-lg-8">
                                                    <span class="pull-left label label-sm label-info">x @{{order.numOrder}}</span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="pull-right">
                                                        <b>$@{{(order.numOrder * order.price) | number}}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"><a ng-click="close(idx)" href='#'><i class='fa fa-close'></i></a></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>
    angular.extend(ControlPad, (function(){                
                return {
                    inventoryCtrl : {
                        path : '/json/llr_json.json'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/inventoryController.js') }}
@stop