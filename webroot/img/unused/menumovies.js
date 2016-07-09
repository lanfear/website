'use strict';
/* Controllers */
angular.module('myApp.values').value('mainMenuItems', []);
                                               
angular.module('myApp.directives')
  .directive('menuMovies', ['mainMenuItems', function(mainMenuItems) {
    return {
        restrict: 'E',
        templateUrl: '/cake/api/templates/menumovies'
     };
  }]);
