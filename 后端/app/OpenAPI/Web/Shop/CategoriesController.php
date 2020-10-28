<?php

namespace App\OpenAPI\Web\Shop;

use App\Models\shopCategories;
use App\Models\shopProduct;
use App\OpenAPI\BaseController;

class CategoriesController extends BaseController
{
    public function getCategoriesByAll()
    {
        $allParentCategories = ShopCategories::where('parent_id', '=', '0')->get(['id', 'order', 'title', 'image', 'description'])->toArray();
        $allParentCategories = $this->arrayInSort($allParentCategories, 'order');
        for ($i = 0; $i < count($allParentCategories); $i++) {
            $pID = $allParentCategories[$i]['id'];
            $children = ShopCategories::where('parent_id', '=', $pID)->get(['id', 'order', 'title', 'image', 'description'])->toArray();
            if (count($children) != 0) {
                $reChildren = $this->arrayInSort($children, 'order', SORT_ASC, SORT_NUMERIC);
            }
            $allParentCategories[$i]['children'] = $reChildren;
            $reChildren = [];
        }
        return $this->reCode200($allParentCategories);
    }

    public function getProductByCategoriesId($id)
    {
        if (isset($id)) {
            $product = shopProduct::where("cid", "=", $id)->where("isDisable", "!=", 1)->get(['id', 'name', 'description', 'price', 'data'])->toArray();
            if ($product != []){
                for ($i = 0; $i < count($product); $i++) {
                    $product[$i]['data'] = count($product[$i]['data']);
                }
                return $this->reCode200($product);
            }else{
                return $this->reCode200([]);
            }
        } else {
            return $this->reError500("传入数据不存在或数据错误!");
        }
    }

    public function getProductInfoByIDAndNone($id)
    {
        if ($this->hasDatabases(new shopProduct(), "cid", $id)) {
            $product = shopProduct::where("cid", "=", $id)->get(['id', 'name', 'description', 'price', 'data'])->toArray();
            for ($i = 0; $i < count($product); $i++) {
                $product[$i]['data'] = count($product[$i]['data']);
            }
            return $this->reCode200($product);
        } else {
            return $this->reError500("传入数据不存在或数据错误!");
        }
    }
}