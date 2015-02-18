@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'inventory/disable', 'method' => 'POST')) }}
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="">Current Inventory</h1>
                    <ul class="media-list" id="currentinventory">
                        <li class="media" ng-repeat="inventory in inventories">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="sample.jpg" width="100">
                            </a>
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4 class="media-heading pull-left">@{{inventory.model}}</h4>
                                        <div class="pull-right">
                                            <span class="bold"><b>$@{{inventory.price}}</b></span>
                                            <div class="btn-group">
                                                <button ng-click="addOrder(inventory)" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Nothing to descript</p>
                                    </div>
                                    <div class="col-md-4">
                                        <ul id="@{{$index}}_sizes">
                                            <li ng-repeat="(key,size) in inventory.quantities">
                                                <a style="display:block;" ng-if="size > 1000" href="#"><span>@{{key}} - </span><span class="label label-info">IN STOCK</span></a>
                                                <a style="display:block;" ng-if="size < 1000 && size >= 500" href="#"><span>@{{key}} - </span><span class="label label-warning">LIMITED STOCK</span></a>
                                                <a style="display:block;" ng-if="size < 500" href="#"><span>@{{key}} - </span><span class="label label-danger">HURRY</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h3>Order Total</h3>
                    <div class="well">
                        <!--
                        <div class="form-group">
                            <span>Subtotal</span>
                            <div class="pull-right">$100</div>
                        </div>
                        <div class="form-group">
                            <span>Tax</span>
                            <div class="pull-right">$6.25</div>
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <div class="pull-right">$106.25</div>
                        </div>
                        <div class="form-group">
                            <button class="pull-right btn btn-sm btn-success">Checkout</button>
                            <button class="pull-left btn btn-sm btn-danger">Cancel</button>
                        </div>-->
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
                    <h3>Selected Items</h3>
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
                                            <span class="label label-info">$@{{order.price}} / XL</span>
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