'use strict';

/* Report Controller */

var module,
    moduleName = "app";
try {
    module = angular.module(moduleName);
} catch(err) {
    module = angular.module(moduleName, []);
}

(function(app, push, check, ctrlpad){
    var newModules = [
            'angularUtils.directives.dirPagination'
        ];
      
    push(app.requires, newModules);  

	// Change your GD ngular stuff so it doesn't bork blade 
	app.config(function($interpolateProvider) {
		$interpolateProvider.startSymbol('<$');
		$interpolateProvider.endSymbol('>');
	});
    
    app.directive('dateonlypicker2', function() {
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

    app.controller('ReportsController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var reportSalesPath		=  ctrlpad.reportSalesCtrl.path;
        var reportInventoryPath =  ctrlpad.reportInventoryCtrl.path;
        var reportReceiptPath	=  ctrlpad.reportReceiptCtrl.path;

        $scope.countItems = 0;
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
		// Get sales reports
        $http.get(reportSalesPath).success(function(v) {
            $scope.countItems = v.count;
            $scope.reportSales = v.data;
			console.log(v.data);
            $scope.isComplete = true;
        });
        
		// Get inventory reports
        $http.get(reportReceiptPath).success(function(v) {
            $scope.countItems = v.count;
            $scope.reportReceipts = v.data;
            $scope.isComplete = true;
        });

		// Get inventory reports
        $http.get(reportInventoryPath).success(function(v) {
            $scope.countItems = v.count;
            $scope.reportInventory = v.data;
            $scope.isComplete = true;
        });
        
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
		$scope.showReceiptDetails = function(id) {
			var items = JSON.parse($scope.reportReceipts[id].data);
			angular.forEach(items, function(detail, model) {
				console.log(model,detail);
			});
			console.log($scope.reportReceipts[id].note);
			alert('Angular blows for rapid development of user interfacing.');
		};

        // bulk action checkboxes
        $scope.checkbox = function() {
            var checked = false;
            $('.bulk-check').each(function() {
            if ($(this).is(":checked")) checked = true;
            });
            if (checked == true) $('.applyAction').removeAttr('disabled');
            else $('.applyAction').attr('disabled', 'disabled');
        };

    }]);
}(module, pushIfNotFound, checkExists, ControlPad));
