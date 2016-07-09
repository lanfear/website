'use strict';
/* Controllers */
angular.module('myApp.values').value('mainMenuItems', []);
                                               
angular.module('myApp.directives')
  .directive('menuTv', ['mainMenuItems', function(mainMenuItems) {
    return {
        restrict: 'E',
        templateUrl: '/cake/api/templates/menutv'
     };
  }]);
