'use strict';
/* Controllers */
angular.module('myApp.controllers').controller('MusicController', ['$scope', '$http', '$rootScope', 'playlist', function ($scope, $http, $rootScope, playlist) {
    var APIBASE = "http://dev.josephdeming.net/cake";
    var APIMUSIC = APIBASE + "/api/music";
    $scope.collections = null;
    $scope.collection = null;
    $scope.slides = [];
    $scope.playlist = [];
    $scope.currentTrack = 0;
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
    $scope.artistName = null;
    $scope.releaseName = null;
    $http.get(APIMUSIC).success(function (data) {
        $scope.collections = angular.fromJson(data);
    });
    $scope.CollectionLoad = function (index, uri)
    {
        $scope.currCollectionIndex = index;
        $scope.hideGalleriesMenu = true;
        $http.get(APIBASE + uri).success(function (data)
        {
            $scope.collection = angular.fromJson(data);
            $scope.slides = $scope.collection.releases;
            $scope.artistName = $scope.collections.artists[index].name;
            $scope.ReleaseLoad(0);
        });
    };
    $scope.ReleaseLoad = function (index) {
        $scope.currSlideIndex = index;
        $http.get(APIBASE + $scope.collection.releases[index]['uri']).success(function (data)
        {
            $scope.playlist = [];
            $scope.release = angular.fromJson(data);
            //$scope.playlist = $scope.release.release;
            $scope.releaseName = $scope.collection.releases[index].name;
            $scope.release.release.forEach(function(playlistItem) {
                $scope.playlist.push({sources: [{src: playlistItem.url, type: 'audio/mpeg'}]});
            });
            updateTrack();
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
    $scope.GetFile = function (index) {
        console.log('Get Info');
        console.log(index);
        var imageObject = $scope.release.release[index];
        $http.get(imageObject.url).success(function (data)
        {
            //$scope.imageInfo = data;
        });
        
    };
    
    $scope.tempSource = function(sources) {
        console.log('here');
    }
    //$scope.$watch(
    //    function (scope) {
    //        return scope.currCollectionIndex;
    //    },
    //    function (newval, oldval) {
    //        if (newval !== null) {
    //        }
    //    }
    //);
    
    var updateTrack = function(){
        $rootScope.$broadcast('audio.set', $scope.playlist[$scope.currentTrack].url, $scope.playlist[$scope.currentTrack], $scope.currentTrack, $scope.playlist.length);
    };
    
    var addToPlaylist = function(item) {
        //item.sources = [{
        //}];
        //{sources: [{src: 'http:\/\/dev.josephdeming.net\/cake\/api\/tv\/Simpsons\/Simpsons 04x04 - Lisa The Beauty Queen.mp4', type: 'video/mp4'}]}
    };

    $rootScope.$on('audio.next', function(){
        $scope.currentTrack++;
        if ($scope.currentTrack < $scope.playlist.length){
            updateTrack();
        }else{
            $scope.currentTrack=$scope.playlist.length-1;
        }
    });

    $rootScope.$on('audio.prev', function(){
        $scope.currentTrack--;
        if ($scope.currentTrack >= 0){
            updateTrack();
        }else{
            $scope.currentTrack = 0;
        }
    });
    
    
}]);