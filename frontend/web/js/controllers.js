'use strict';

var controllers = angular.module('controllers', []);

controllers.controller('LeaseController', ['$scope', 'LeaseService',
    function ($scope, LeaseService) {
        $scope.leases = [];
        LeaseService.get().then(function (data) {
            if (data.status == 200)
                $scope.leases = data.data;
        }, function (err) {
            console.log(err);
        })
    }
]);