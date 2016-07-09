'use strict';
/* Controllers */
angular.module('myApp.controllers').controller('TvController', ['$scope', '$http', function ($scope, $http) {
    var APIBASE = "http://dev.josephdeming.net/cake";
    var APITV = APIBASE + "/api/tv";
    $scope.collections = null;
    $scope.collection = null;
    $scope.slides = [];
    $scope.image = {
        uri: null,
        prev: null,
        next: null,
        name: null
    }
    $scope.release = null;
    $scope.imageInfo = null;
    $scope.hideGalleriesMenu = false;
    $scope.hideAlbumsMenu = false;
    $scope.currCollectionIndex = null;
    $scope.currImageIndex = null;
    $scope.collectionName = null;
    $scope.releaseName = null;
    $http.get(APITV).success(function (data) {
        $scope.collections = angular.fromJson(data);
    });
    $scope.CollectionLoad = function (index, uri)
    {
        $scope.currCollectionIndex = index;
        $scope.hideGalleriesMenu = true;
        $http.get(APIBASE + uri).success(function (data)
        {
            $scope.collection = angular.fromJson(data);
            $scope.slides = $scope.collection.collection;
            $scope.collectionName = $scope.collections.collection[index].name;
            //$scope.ReleaseLoad(0);
        });
    };
    $scope.ReleaseLoad = function (index) {
        $scope.currSlideIndex = index;
        $http.get(APIBASE + $scope.collection.releases[index]['uri']).success(function (data)
        {
            $scope.release = angular.fromJson(data);
            $scope.releaseName = $scope.collection.releases[index].name
        });
    };
    $scope.GetInfo = function (index) {
        console.log('Get Info');
        console.log(index);
        var imageObject = $scope.collection.gallery[index];
        $http.get(imageObject.urlinfo).success(function (data)
        {
            $scope.imageInfo = data;
        });
        
    };
    $scope.$watch(
        function (scope) {
            return scope.currCollectionIndex;
        },
        function (newval, oldval) {
            if (newval !== null) {
            }
        }
    );
    
}]);