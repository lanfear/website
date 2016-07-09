var slideViewer = angular.module('SlideViewer', ['ngAnimate', 'ngTouch']);

slideViewer.animation('.slide-animation', function () {
   return {
       beforeAddClass: function (element, className, done) {
           var scope = element.scope();
           if (className == 'ng-hide') {
               var finishPoint = element.parent()[0].offsetWidth;
               if (scope.direction !== 'right') { finishPoint = -finishPoint; }

               if (scope.transition == "fade") {
                 TweenMax.to(element, 0.45, { autoAlpha: 0, onComplete: done });
               } else {
                 TweenMax.to(element, 0.35, { left: finishPoint, onComplete: done });
               }
           } else {
               done();
           }
       },
       beforeRemoveClass: function (element, className, done) {
           var scope = element.scope();
           if (className == 'ng-hide') {
               element.removeClass('ng-hide');

               var startPoint = element.parent()[0].offsetWidth;
               if (scope.direction === 'right') { startPoint = -startPoint; }

               if (scope.transition == "fade") {
                 TweenMax.to(element, 0.45, { autoAlpha: 1, onComplete: done, startAt: { autoAlpha: 0 } });
               } else {
                 TweenMax.to(element, 0.35, { left: 0, onComplete: done, startAt: { left: startPoint } });
               }
           } else {
               done();
           }
       }
   };
});

