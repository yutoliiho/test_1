<?php

use Illuminate\Routing\Router;

/*
Route::domain('{admin}.bcs.com')->group(function () {

    Admin::registerAuthRoutes();
    Route::group([
        'prefix'        => config('admin.route.prefix'),
        'middleware'    => config('admin.route.middleware'),
    ], function (Router $router) {

        $router->get('/', '\App\Admin\Controllers\HomeController@index');

        $router->resource('shop/categories',\App\Admin\Controllers\Shop\CategoriesController::class);

    });

});*/

Admin::registerAuthRoutes();
Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    // 商城模块
    $router->resource('shop/categories', Shop\CategoriesController::class);
    $router->resource('shop/product', Shop\ProductController::class);
    $router->resource('shop/order', Shop\OrderController::class);

    // 供应商模块
    $router->resource('supplier/data', Supplier\DataController::class);
    $router->resource('supplier/list', Supplier\ListController::class);
    $router->resource('supplier/order', Supplier\OrderController::class);

});
