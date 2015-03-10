'use strict';

/* AutoComplete */

angular.module('ControlPadAutoComplete',[])
.directive('autoComplete', ['$http','shared',function($http,shared) {
        
    return {
        restrict:'AEC',
        scope:{
            data: '=item',
            list: '=option'
        },
        link:function(scope,elem,attrs){
            scope.$watch('data', function(val){
                if(val != undefined && val.length >= 2){                       
                    if(shared.requestPromise && shared.getIsLoading()){
                        shared.requestPromise.abort();    
                    }
                    shared.requestPromise = shared.requestData(attrs.url+scope.data);
                    shared.requestPromise.then(function(v){
                        scope.list = v.data;    
                    })
                }
            });
        }
    }
}]);

