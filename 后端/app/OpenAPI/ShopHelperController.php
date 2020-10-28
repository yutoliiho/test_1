<?php
/**
 * Created by PhpStorm.
 * User: rnbug
 * Date: 2018/12/14
 * Time: 20:46
 */

namespace App\OpenAPI;

use App\Models\shopProduct;

class ShopHelperController extends BaseController
{
    public function getAprice($pid){
        return (float)shopProduct::find($pid)->price;
    }
    public function getBprice($pid,$count){
        return round($this->getAprice($pid) * $count,2);
    }
    public function getProductName($pid){
        return shopProduct::find($pid)->name;
    }
    public function getOrderBodyInfo($data){
        /*
        $data = json_decode($data,true);
        $data = json_decode($data['data'],true);
        $str = "Count ".count($data);*/
        return $str;
    }
}