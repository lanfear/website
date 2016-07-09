'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', [
  'ngRoute',
  'fallback.src',
  'myApp.values',
  'myApp.filters',
  'myApp.services',
  'myApp.directives',
  'myApp.controllers',
  'ngSanitize',
  'com.2fdevs.videogular',
  'com.2fdevs.videogular.plugins.controls',
  'com.2fdevs.videogular.plugins.overlayplay',
  'com.2fdevs.videogular.plugins.poster',
  'com.2fdevs.videogular.plugins.buffering',
  'SlideViewer'  
]).
config(['$routeProvider', function($routeProvider) {
  //$routeProvider.when('/view1', {templateUrl: 'partials/partial1.html', controller: 'MyCtrl1'});
  //$routeProvider.when('/view2', {templateUrl: 'partials/partial2.html', controller: 'MyCtrl2'});
  //$routeProvider.otherwise({redirectTo: '/view1'}); //default
}]);

angular.module('myApp.values', []);
angular.module('myApp.directives', []);
angular.module('myApp.controllers', []);
angular.module('myApp.services', []);
