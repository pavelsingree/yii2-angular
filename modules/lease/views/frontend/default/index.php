<?php
//$this->title = \modules\seo\helpers\Meta::all('lease', $model);
?>

<div class="lease-default-index" data-ng-controller="LeaseController">
    <div>
        <h1>All Leases</h1>
        <div data-ng-show="leases.length > 0">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Trim</th>
                </thead>
                <tbody>
                <tr data-ng-repeat="lease in leases">
                    <td>{{lease.year}}</td>
                    <td>{{lease.make}}</td>
                    <td>{{lease.model}}</td>
                    <td>{{lease.trim}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div data-ng-show="leases.length == 0">
            No results
        </div>
    </div>
</div>
