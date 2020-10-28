<?php
/**
 * Created by PhpStorm.
 * User: rnbug
 * Date: 2018/12/17
 * Time: 9:21
 */

namespace App\Supplier;


use App\Http\Controllers\Controller;
use App\Models\shopOrder;
use App\Models\shopSupplierList;
use App\Models\shopSupplierOrder;

class executeOrder extends Controller
{
    public function index()
    {
        $allNoneExecuteOrder = shopOrder::all()->where('hasOff', '!=', '1');
        foreach ($allNoneExecuteOrder as $item) {
            if ($this->countOrderData($item->data) == $this->getSupOrderPartCount($item->orderId)) {
                // 产品的数据和供应商订单表的数据条数一致
                dump("产品的数据和供应商订单表的数据条数一致");

            } else {
                // 不一致
                dump("产品的数据和供应商订单表的数据条数不一致");

                $this->makeSupOrder($item);


            }
        }
    }

    protected function countOrderData($data)
    {
        return count($this->getOrderData($data));
    }

    protected function getOrderData($data)
    {
        return json_decode($data, true)['data'];
    }

    protected function getSupOrderPartCount($orderId)
    {
        return count(shopSupplierOrder::where('orderID', $orderId)->get());
    }

    protected function makeSupOrder($item)
    {
        dump($item);
        $jsonData = json_decode($item->data,true)['data'];
        for ($i = 0; $i < $this->countOrderData($item->data); $i++) {
            //dump("API ID:",$jsonData[$i]['supService']);
            $supInfo = shopSupplierList::where('id',$jsonData[$i]['supService'])->first();
            $jsonData[$i]['key'] = $supInfo->key;
            $jsonData[$i]['url'] = $supInfo->url;

            dump($jsonData[$i]);
        }
    }
}