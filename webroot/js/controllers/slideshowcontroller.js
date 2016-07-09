'use strict';
/* Controllers */
angular.module('myApp.controllers').controller('SlideshowController', ['$scope', '$http', function ($scope, $http) {
    var APIBASE = "http://dev.josephdeming.net/cake";
    var APIPHOTOS = APIBASE + "/api/photos";
    $scope.collections = null;
    $scope.collection = null;
    $scope.slides = [];
    $scope.image = {
        uri: null,
        prev: null,
        next: null,
        name: null
    }
    $scope.imageInfo = null;
    $scope.hideGalleriesMenu = false;
    $scope.currCollectionIndex = null;
    $scope.currImageIndex = null;
    $http.get(APIPHOTOS).success(function (data)
    {
        $scope.collections = angular.fromJson(data);
    });
    $scope.CollectionLoad = function (index, uri)
    {
        $scope.currCollectionIndex = index;
        $scope.hideGalleriesMenu = true;
        $http.get(APIBASE + uri).success(function (data)
        {
            $scope.collection = angular.fromJson(data);
            $scope.slides = $scope.collection.gallery;
        });
    };
    $scope.ImageLoad = function (index)
    {
        $scope.currSlideIndex = index;
    };
    $scope.GetInfo = function (index)
    {
        console.log('Get Info');
        console.log(index);
        var imageObject = $scope.collection.gallery[index];
        $http.get(imageObject.urlinfo).success(function (data)
        {
            $scope.imageInfo = data;
        });
        
    }
}]);