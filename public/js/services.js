'use strict';

/* Services */

angular.module('ControlPadServices', [])

.service("shared", ['$http','$q', '$rootScope',function($http, $q, $rootScope){
    var isLoading = false;
    var sharedSrv = {};
    
    sharedSrv.signupData = {};
    sharedSrv.cart = [];
    sharedSrv.next = false;
    sharedSrv.getIsLoading = function () {
        return isLoading;
    };
    
    sharedSrv.requestPromise = null;  
    sharedSrv.requestData = function(url){
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

    sharedSrv.updateSignUpData = function(n){
        this.signupData = n;
        this._brdcstUpdateSignUpData();
    };

    sharedSrv.updateCart = function(n){
        this.cart = n;
        this._brdcstUpdateCart();    
    };
    
    sharedSrv.updateLocalCart = function(){
        this._brdcstUpdateLocalCart();    
    }; 
    
    sharedSrv.updateNext = function(d){
        this.next = d;
        this._brdcstUpdateNext();    
    };
    
    sharedSrv.updateLocalNext = function(d){
        this.next = d;
        this._brdcstUpdateLocalNext();    
    }; 
    
    /* event broadcasters */
    
    sharedSrv._brdcstUpdateCart = function(){
        $rootScope.$broadcast('handleUpdateCart');
    }
    
    sharedSrv._brdcstUpdateLocalCart = function(){
        $rootScope.$broadcast('handleUpdateLocalCart');
    }
    
    sharedSrv._brdcstUpdateSignUpData = function(){
        $rootScope.$broadcast('handleUpdateSignUpData');
    };
    
    sharedSrv._brdcstUpdateNext = function(){
        $rootScope.$broadcast('handleUpdateNext');
    };
    
    sharedSrv._brdcstUpdateLocalNext = function(){
        $rootScope.$broadcast('handleUpdateLocalNext');
    };
    
    return sharedSrv;
}]);
