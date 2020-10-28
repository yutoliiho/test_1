<?php

namespace App\OpenAPI\Web\Pay;

use App\Models\shopOrder;
use App\OpenAPI\ShopHelperController;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayController extends ShopHelperController
{
    public function router(Request $request)
    {
        $data = $this->hasTrueData($request);
        if ($data["f"]) {
            $se = $data['m'];

            $pid = $se['pid'];
            $oid = $this->orderID($se['payment']);

            $order = new shopOrder();
            $order->orderId = $oid;
            $order->pid = $pid;
            $order->count = 1;
            $order->aPrice = $this->getAprice($pid);
            $order->bPrice = $this->getBprice($pid, $order->count);
            $order->email = $se['mail'];
            $order->payHas = 0;
            $order->payName = $se['payment'];
            $order->data = json_encode($se,true);

            $order->save();

            $reData = $this->pay($order,$oid);

            return $this->reCode200($reData);
        } else {
            return $this->reError500($data["m"]);
        }
    }

    protected function pay($order,$oid){

        $data = [
            "subject" =>$this->getProductName($order->pid),
            "body" =>$order->email,
            "sum" => $order->bPrice,
            "order_no" => $oid
        ];

        if ($order->payName === "paypal"){
            return "error";
        }else if ($order->payName === "alipay"){
            $data['channel'] = "ali_qr";
        }else if ($order->payName === "wepay"){
            return "error";
        }
        $pay = new Pay();
        $result = $pay->pay($data);

        if (isset($result['result_code']) && isset($result['result_msg'])){
            if ($order->payName === "paypal"){

            }else if ($order->payName === "alipay"){

                return ["link"=>$result['charge']['credential']['order_qr'],"pid"=>$order->pid];

            }
        }else{
            return $result;
        }
    }

    protected function hasTrueData(Request $request)
    {
        $flag = [
            "f" => false,
            "m" => null,
        ];
        $all = $request->all();
        $validator = Validator::make($all, [
            'mail' => 'required|email',
            'payment' => 'required|string',
            'pid' => 'required|integer',
            'data.*.link' => 'required|string',
            'data.*.quantity' => 'required|integer',
            'data.*.service' => 'required|integer',
            'data.*.supService' => 'required|integer',
        ]);
        if (!$validator->fails()) {
            $flag["f"] = true;
            $flag["m"] = $all;
        } else {
            $flag["m"] = $validator->errors()->messages();
        }
        return $flag;
    }

    protected function orderID($p)
    {
        $str = substr($p, 0, 1);
        $str .= date('YmdHis');
        $str .= substr($p, 0, 1);
        $str .= uniqid() . rand(100, 999);
        return strtoupper($str);
    }
}