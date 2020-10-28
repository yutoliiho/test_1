<?php
namespace App\OpenAPI\Web\Pay;

use IredCap\Pay\Charge;
use IredCap\Pay\Http\HttpRequest;

class Pay
{
    public function pay($param)
    {
        //2.支付主体 构建请求参数
        $payload = [
            "out_trade_no" =>  $param['order_no'],
            "subject" => $param['subject'],
            "body" => $param['body'],
            "amount" => $param['sum'],
            "currency" =>'RMB',
            "channel" => strtolower($param['channel']),
            "extparam" => [
                "nocestr" => $this->getRandChar()
            ], //支付附加参数
        ];
        //提交支付
        $order = Charge::create($payload);
        return $order;
    }

    public function query($param){
        //2.查询主体 构建请求参数
        $payload = [
            "out_trade_no" =>  $param['order_no'], //商户订单号
            "channel" => strtolower($param['type']), //支付方式 小写
        ];
        //提交支付
        $order = Charge::query($payload);
        return $order;
    }

    private function getRandChar($length = 32){
        $str = null;
        $strPol = "ee6ee048ff5e2a7d1f19411686448f02";
        $max = strlen($strPol) - 1;
        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }

    public function callback()
    {
        return Charge::verify();
    }
}