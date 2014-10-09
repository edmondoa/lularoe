<label for="dob">Date of Birth</label>
<div class="input-group" ng-controller="DatepickerDemoCtrl">
    <input type="text" name="dob" id="dob" class="form-control" datepicker-popup="{{format}}" ng-model="dt" is-open="opened" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" />
    <span class="input-group-btn">
        <button type="button" class="btn btn-default" ng-click="open($event)">
            <i class="glyphicon glyphicon-calendar"></i>
        </button>
    </span>
</div>