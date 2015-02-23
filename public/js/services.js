'use strict';

/* Services */

angular.module('ControlPadServices', [])

.service("shared", ['$http','$q',function($http, $q){
    var isLoading = false;
    var requestPromise = null;
    var requestData = function(url){
        isLoading = true;
        var canceller = $q.defer();

        var request = $http.get(url, { timeout: canceller.promise});
        
        var promise = request.then(
            function( response ) {
                isLoading = false;
                return( response.data );
            },
            function( response ) {
                return( $q.reject( "Something went wrong" ) );
            }
        );
        
        promise.abort = function() {
            isLoading = false;
            if(canceller){
                canceller.resolve();
            }
        };
        
        promise.finally(
            function() {
                /*console.log( "Cleaning up object references." );*/
                canceller = request = promise = null;
            }
        );
        
        return( promise );
        
    };

    return {
        getIsLoading: function () {
            return isLoading;
        },
        requestPromise :requestPromise,
        requestData : requestData
    };
}]);
