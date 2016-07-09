'use strict';
/* Controllers */
angular.module('myApp.values').value('mainMenuItems', []);
                                               
angular.module('myApp.directives')
  .directive('menuItemContent', ['mainMenuItems', function(mainMenuItems) {
    return {
        restrict: 'E',
        scope: {
          id: '@'
        },
        link: function(scope, element, attrs) {
          scope.getTemplateUrl = function() {
            return '/cake/api/templates/menu' + scope.id;
          }
        },
        template: '<div ng-include="getTemplateUrl()"></div>'
        //templateUrl: '/cake/api/templates/menuphotos'
     };
  }]);
