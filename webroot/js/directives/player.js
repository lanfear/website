'use strict';
angular.module('myApp.values').value('playlist', [ {sources: [{src: 'http:\/\/dev.josephdeming.net\/cake\/api\/tv\/Simpsons\/Simpsons 02x16 - Barts Dog Gets an F.mp4', type: 'video/mp4'}]}, {sources: [{src: 'http:\/\/dev.josephdeming.net\/cake\/api\/tv\/Simpsons\/Simpsons 02x16 - Barts Dog Gets an F.mp4', type: 'video/mp4'}]}]);

/* Directives */
angular.module('myApp.directives')
  .directive('player', ['$q', 'playlist', function($q, playlist) {
    return {
        transclude: true,
        restrict: 'E',
        scope: {
          mediaType: '=?',
          template: '=?',
          currentPlaylistIndex: '@?'
          },
        controller: function ($scope, $sce, $timeout, playlist) {
          var state = null;
          var api = null;
          var isCompleted = false;
          
          debugger;
          $scope.playlist = playlist;
          $scope.template = $scope.template || '/cake/api/css/vendor/videogular.css';
          $scope.mediaType = $scope.mediaType || 'video';
          $scope.currentPlaylistIndex = $scope.currentPlaylistIndex || 0;
          
          $scope.onPlayerReady = function(a) {
              api = a;
          };
          
          $scope.onChangeSource = function(source) {
            console.log('here');
            console.log(source);
          }

          $scope.onCompleteVideo = function() {
              isCompleted = true;

              $scope.currentPlaylistIndex++;

              if ($scope.currentPlaylistIndex >= $scope.playlist.length) $scope.currentPlaylistIndex = 0;

              $scope.setVideo($scope.currentPlaylistIndex);
          };
          
          $scope.config = {
              preload: "none",
              autoHide: true,
              autoHideTime: 3000,
              autoPlay: false,
              sources: ($scope.playlist && $scope.playlist.length > 0) ? $scope.playlist[0].sources : null,
              theme: {
                  url: $scope.template
              },
              plugins: {
                  poster: "http://www.videogular.com/assets/images/videogular.png"
              }
          };

          $scope.setVideo = function(index) {
              if (!$scope.playlist || $scope.playlist.length <= index) {
                return;
              }
              if (api.currentState === "play") { api.stop(); }
              $scope.currentPlaylistIndex = index;
              $scope.config.sources = $scope.playlist[index].sources;
              api.changeSource($scope.config.sources);
              $timeout(api.play.bind(api), 100);
          };
          
          $scope.tempSource = function(sources) {
              console.log('here');
          }
          
          $scope.$watch(function() {
            return $scope.playlist.length;
          }, function(newVal, oldVal) {
            if (oldVal === 0 && newVal > 0) {
              $scope.setVideo(0);
            }
          });
        },
        templateUrl: '/cake/api/templates/player'
     };
  }]);
