angular.module('jqDatePicker',[])
.directive('jqdatepicker', function() {
    return {
        restrict: 'C',
        require: 'ngModel',
        link: function(scope, element, attrs, ctrl) {
            $(element).datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(date) {
                    ctrl.$setViewValue(date);
                    ctrl.$render();
                    scope.$apply();
                }
            });
        }
    };
});