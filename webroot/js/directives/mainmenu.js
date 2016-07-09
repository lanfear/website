'use strict';
/* Controllers */
angular.module('myApp.values').value('mainMenuItems', {});
angular.module('myApp.values').value('mainContentItems', {});
                                               
//angular.module('myApp.directives')
//  .directive('mainMenuItem', ['mainMenuItems', function(mainMenuItems) {
//    var APIBASE = "http://dev.josephdeming.net/cake";
//    
//    return {
//        transclude: true,
//        restrict: 'E',
//        scope: {
//          name: '@',
//          value: '@'
//        },
//        controller: function ($scope, mainMenuItems) {
//            mainMenuItems[$scope.name] = {
//              name: $scope.name,
//              label: $scope.value,
//              visible: false,
//            };
//            
//            $scope.toggleVisible = function() {
//              for (var menuName in mainMenuItems) {
//                if (mainMenuItems.hasOwnProperty(menuName)) {
//                  mainMenuItems[menuName].visible = menuName === $scope.name ? !mainMenuItems[menuName].visible : false;
//                }
//              }
//            }
//        },
//        templateUrl: '/cake/api/templates/mainmenuitem'
//     };
//  }]);
//
//angular.module('myApp.directives')
//  .directive('menuItemContent', ['mainMenuItems', function(mainMenuItems) {
//    return {
//        restrict: 'E',
//        scope: {
//          name: '@'
//        },
//        controller: function ($scope, mainMenuItems) {
//          $scope.getTemplateUrl = function() {
//            return '/cake/api/templates/menu' + $scope.name;
//          }
//          
//          $scope.isVisible = function() {
//            return mainMenuItems[$scope.name] ? mainMenuItems[$scope.name].visible : false;
//          }
//        },
//        template: '<li class="menu-content" ng-include="getTemplateUrl()" ng-class="{hidden: !isVisible()}"></li>'
//     };
//  }]);

angular.module('myApp.directives')
  .directive('menuContentItem', ['mainContentItems', function(mainContentItems) {
    return {
        restrict: 'E',
        scope: {
          name: '@',
          label: '@'
        },
        controller: function ($scope, mainContentItems) {
          mainContentItems[$scope.name] = {
            name: $scope.name,
            label: $scope.label,
            expanded: false
          };

          $scope.getTemplateUrl = function() {
            return '/cake/api/templates/content' + $scope.name;
          }
          
          $scope.isExpanded = function() {
            return mainContentItems[$scope.name] ? mainContentItems[$scope.name].expanded : false;
          }
          
          $scope.toggleExpanded = function() {
            mainContentItems[$scope.name].expanded = !mainContentItems[$scope.name].expanded;
          }
        },
        template: '<li class="content-item">' +
                  '<div class="content-item-header" ng-click="toggleExpanded()">{{label}}</div>' +
                  '<div ng-include="getTemplateUrl()" ng-class="{hidden: !isExpanded()}">' +
                  '</div>'+
                  '</li>'
     };
  }]);
