'use strict';
angular.module('myApp.values').value('playlist', [ {sources: [{src: 'http:\/\/dev.josephdeming.net\/cake\/api\/tv\/Simpsons\/Simpsons 04x04 - Lisa The Beauty Queen.mp4', type: 'video/mp4'}]}, {sources: [{src: 'http:\/\/dev.josephdeming.net\/cake\/api\/tv\/Simpsons\/Simpsons 04x04 - Lisa The Beauty Queen.mp4', type: 'video/mp4'}]}]);

/* Directives */
angular.module('myApp.directives')
  .directive('playlist', ['$q', 'playlist', function($q, playlist) {
    return {
        transclude: true,
        restrict: 'E',
        scope: {
          currentPlaylistIndex: '@?'
        },
        controller: function ($scope, $sce, $timeout, playlist) {
          $scope.playlist = playlist;
        },
        templateUrl: '/cake/api/templates/playlist'
     };
  }]);