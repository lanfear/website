'use strict';
/* Controllers */
angular.module('myApp.values').value('mainMenuItems', []);
                                               
angular.module('myApp.directives')
  .directive('menuMusic', ['mainMenuItems', function(mainMenuItems) {
    return {
        restrict: 'E',
        templateUrl: '/cake/api/templates/menumusic'
     };
  }]);
