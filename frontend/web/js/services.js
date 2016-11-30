'use strict';

var app = angular.module('app');

app.service('LeaseService', function($http) {
    this.get = function() {
        return $http.get('/api/leases');
    };
    this.post = function (data) {
        return $http.post('/api/leases', data);
    };
    this.put = function (id, data) {
        return $http.put('/api/leases/' + id, data);
    };
    this.delete = function (id) {
        return $http.delete('/api/leases/' + id);
    };
});