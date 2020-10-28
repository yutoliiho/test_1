<?php

use Illuminate\Routing\Router;

Route::group([

    'prefix' => 'admin/api',
    'namespace' => 'App\\OpenAPI\\Admin\\Controllers',
    'middleware' => ['web', 'admin'],

], function (Router $router) {

    $router->get('/supplier/list/balance/update/{id}', 'UpdateSupplierBalance@index')->name('Admin.API.BalanceUpdate');
    $router->get('/supplier/list/service/data/{id}', 'GetSupplierData@index')->name('Admin.API.GetSupplierData');

});