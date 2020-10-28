<?php

namespace App\OpenAPI\Admin\Controllers;

use App\Models\shopSupplierList;
use App\OpenAPI\BaseController;
use App\Supplier\Supplier;

class UpdateSupplierBalance extends BaseController
{
    public function index($id)
    {
        if (isset($id) && $this->hasDatabases(new shopSupplierList,"id",$id)) {
            try{
                $api = shopSupplierList::find($id);
                $supplier = new Supplier($api->url, $api->key);
                $api->balance = $supplier->balance()->balance;
                $api->save();
            }catch (\Exception $exception){
                return back()->withErrors(["服务器无法访问供应商,请假查服务器网络"]);
            }finally{
                return back();
            }
        }else{
            return back()->withErrors(["传入数据不正确"]);
        }
    }
}