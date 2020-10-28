<?php
namespace App\OpenAPI\Web\Shop;

use App\Models\shopProduct;
use App\Models\shopSupplierData;
use App\OpenAPI\BaseController;

class ProductController extends BaseController
{
    public function getProductInfoByID($id){
        if ($this->hasDatabases(new shopProduct(), "id", $id)) {
            $product = ShopProduct::where('id', $id)->first()->get(['id','name','price','description','data'])->toArray()[0];
            for ($i = 0; $i < count($product['data']); $i++) {
                $data = ShopSupplierData::where('id',$product['data'][$i])->get(['id','data'])->toArray()[0];
                $data['data'] = json_decode($data['data']);
                $data['service'] = $data['data']->system->service;
                $data['supplier'] = $data['data']->supID;
                $temp=array();
                for ($j=0;$j<count($data['data']->user);$j++){
                    $data['data']->user[$j]->private = $data['data']->user[$j]->private == "on" ? true : false;
                    $data['data']->user[$j]->id = $data['id'];
                    array_push($temp,$data['data']->user[$j]);
                }
                unset($data['data']->user);
                $data['data'] = $temp;
                $product['data'][$i] = $data;
            }
            return $this->reCode200($product);
        } else {
            return $this->reError500("传入数据不存在或数据错误!");
        }
    }
}