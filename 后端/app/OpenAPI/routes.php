<?php

require_once app_path('OpenAPI/Admin/routes.php');

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    // 分类API
    // 查询所有
    $api->get('/web/categories/find/all','App\OpenAPI\Web\Shop\CategoriesController@getCategoriesByAll');
    // 根据ID查询
    $api->get('/web/categories/find/id/{id}','App\OpenAPI\Web\Shop\CategoriesController@getProductByCategoriesId')->where('id', '[0-9]+');

    // 产品ID
    // 根据ID查询
    $api->get('/web/product/find/id/{id}','App\OpenAPI\Web\Shop\ProductController@getProductInfoByID')->where('id', '[0-9]+');
    // 根据ID查询所有包括已下架
    $api->get('/web/product/find/id/{id}/none','App\OpenAPI\Web\Shop\ProductController@getProductInfoByIDAndNone')->where('id', '[0-9]+');

    // 支付
    // 传入 data 和 payment 和email
    $api->post('/web/pay','App\OpenAPI\Web\Pay\PayController@router');

    $api->post('/pay/notify','App\OpenAPI\Web\Pay\Notify@index');
    $api->post('/pay/return','App\OpenAPI\Web\Pay\Notify@index');


    // 自动完成
    // 获取媒体
    $api->get('/auto/inst/media','App\OpenAPI\Web\Auto\ins\media@index');


});