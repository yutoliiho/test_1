<?php
namespace App\OpenAPI\Admin\Controllers;

use App\Models\shopSupplierList;
use App\OpenAPI\BaseController;
use App\Supplier\Supplier;

class GetSupplierData extends BaseController
{
    public function index($id){
        if (isset($id) && $this->hasDatabases(new shopSupplierList(),"id",$id)) {
            try{
                $api = shopSupplierList::find($id);
                $supplier = new Supplier($api->url, $api->key);
                $api = $supplier->services();
            }catch (\Exception $exception){
                return $this->reError500("服务器无法访问供应商,请检查服务器网络");
            }finally{
                return $this->reCode200($api);
            }
        }else{
            return $this->reError500("参数不正确");
        }
    }
}