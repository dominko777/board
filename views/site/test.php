<?php
Yii::app()->clientScript->registerScriptFile('//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.17/angular.min.js');
?>
  

<h2>AngularJS Sample Application</h2>

      <div ng-app="myApp" ng-init="name='World'">
        <div class="container" ng-controller="TextAreaWithLimitCtrl">
            <span ng-class="{'text-warning' : shouldWarn()}">Remaining: {{remaining()}}</span>
                <div class="row">
                    <textarea ng-model="message">{{message}}</textarea>
                </div>
                <div class="row">
                  <button  ng-disabled="!hasValidLength()" ng-click="send()">Send</button>
                  <button ng-click="clear()">Clear</button>
                </div>
        </div>
        </div>  

<script>  
    angular.module('myApp', [])
      .controller('TextAreaWithLimitCtrl', ['$scope', function ($scope) {
        WARN_THRESHOLD = 10;
            $scope.remaining = function () {
                return 100 - $scope.message.length;
            };

            $scope.shouldWarn = function () {
                return $scope.remaining() < WARN_THRESHOLD;
                };
      }]);
      </script>

