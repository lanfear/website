'use strict';
/* Controllers */
angular.module('myApp.controllers').controller('SearchController', ['$scope', '$http', function ($scope, $http) {
    
    var searchEndpoint = '/cake/api/search/{0}';
    var tvCollectionsEndpoint = '/cake/api/tv'
    
    $scope.searchKeyword = null;
    $scope.searchResults = null;
    $scope.playlist = [];
    
    $scope.searchWorkflow = function() {
        console.log('Keyword:' + $scope.searchKeyword);
        console.log(searchEndpoint.format($scope.searchKeyword));
        $http.get(searchEndpoint.format($scope.searchKeyword)).success(function(data) {
            if (data.results && data.results.length > 0) {
                $http.post(tvCollectionsEndpoint, data.results).success(function(postdata) {
                    $scope.searchResults = postdata.collection;
                    $scope.searchResults.forEach(function (playlistItem) {
                        console.log('Item: ' + playlistItem.filename);
                        $scope.playlist.push({sources: [{src: playlistItem.url, type: 'video/mp4'}]});
                    });
                });
            }
        });
    };
}]);