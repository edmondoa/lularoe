@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'inventory/disable', 'method' => 'POST')) }}
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="">Current Inventory</h1>
                    <ul class="media-list" id="currentinventory">
                        <li class="media" ng-repeat="(k,inventory) in inventories">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="sample.jpg" width="100">
                            </a>
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="media-heading pull-left">@{{inventory.model}}</h4>
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
                                        <h5>Size</h5>
                                        <ul class="nav nav-pills">
                                            <li ng-repeat="(key,size) in inventory.sizes">
                                                    <a class="pull-left" style="padding-right: 0;padding-left: 0;" href="#">
                                                        <input class="bulk-check" type="checkbox" name="size_@{{k}}_@{{$index}}" ng-model="size.checked" ng-checked="size.checked" value="@{{key}}">
                                                    </a>
                                                    <a ng-click="toggleCheck(inventory,size)" class="pull-left" ng-if="size.value > 1000" href="#"><span>@{{size.key}} - </span><span class="label label-info">IN STOCK</span></a>
                                                    <a ng-click="toggleCheck(inventory,size)" class="pull-left" ng-if="size.value < 1000 && size >= 500" href="#"><span>@{{size.key}} - </span><span class="label label-warning">LIMITED STOCK</span></a>
                                                    <a ng-click="toggleCheck(inventory,size)"class="pull-left" ng-if="size.value < 500" href="#"><span>@{{size.key}} - </span><span class="label label-danger">HURRY</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-top: 1px solid rgba(0,0,0,0.1);"/>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h3>Order Total</h3>
                    <div class="well">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right">$100</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td align="right">$6.25</td>
                                </tr>
                                <tr>
                                    <td><label>Total</label></td>
                                    <td align="right">$106.25</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button class="pull-right btn btn-sm btn-success">Checkout</button>
                                        <button class="pull-left btn btn-sm btn-danger">Cancel</button>
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
                                    <div class="well clearfix" ng-repeat="order in orders | orderBy: 'itemnumber'">
                                    <div class="pull-right"><a ng-click="close(order)" href='#'><i class='fa fa-close'></i></a></div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span class="label label-info">$@{{order.price}} / @{{order.size}}</span>
                                            <img src="sample.jpg" width="50" />
                                            <div style="width:80px">
                                                <span class="btn btn-xs btn-success" ng-click="">+</span>
                                                <span class="btn btn-xs btn-danger" ng-click="">-</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h4 class="media-heading"> @{{order.itemnumber}} </h4>
                                            <p class="pull-left">Some semblance of a description could go here</p>
                                            <div class="media-body">
                                                <div class="col-lg-8">
                                                    <span class="label label-sm label-info">x @{{order.numOrder}}</span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="pull-right">
                                                        <b>$@{{order.numOrder * order.price}}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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