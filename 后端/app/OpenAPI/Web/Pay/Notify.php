<?php
namespace App\OpenAPI\Web\Pay;

use App\OpenAPI\ShopHelperController;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Log;

class Notify extends ShopHelperController
{
    use Helpers;
    public function index(Request $request)
    {
        $this->logs("Request Head::  ".json_encode($request->header()));
        $this->logs("Request Body::  ".json_encode($request->all()));
        $pay = new Pay();
        $apiResult["result_code"] = "OK";
        $apiResult["result_msg"] = "FAIL";
        try {
            if ($pay->callback()) {
                $this->logs("Request Keys验证通过");

                // 我这里还没做操作，只是调用了
                /*
                 * {
    "result_code":"OK",
    "result_msg":"SUCCESS",
    "charge":{
        "puid":0,
        "out_trade_no":"A20190102010916A5C2C0F3C543189",
        "subject":"Media Likes",
        "body":"rnbug@qq.com",
        "channel":"ali_qr",
        "extra":"{"nocestr":"Wx7jCYi2jFvQVjsTrbK7HVpjTwcyAXZ6","o":"A20190102010916A5C2C0F3C54318953"}",
        "amount":"0.010",
        "income":"0.000",
        "user_in":"0.000",
        "agent_in":"0.000",
        "platform_in":"0.000",
        "currency":"RMB",
        "client_ip":"43.250.201.57",
        "return_url":"http://foliker.demo.hi.cn/api/pay/return",
        "notify_url":"http://foliker.demo.hi.cn/api/pay/notify"
    }
}*/





                $apiResult["result_msg"] = "SUCCESS";
            } else {
                $this->logs("验证失败");
            }
        } catch (\Exception $exception) {
            $this->logs($exception->getMessage());
        }
        return $apiResult;
    }

    protected function logs($messages)
    {
        $log = new Logger("PayCenter");

        $logDir = storage_path('logs/pay');
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        try {
            $log->pushHandler(new StreamHandler($logDir . '/' . date('Y-m-d') . '-notify.log', Logger::INFO));
            $log->info($messages);
        } catch (\Exception $exception) {
            Log::info($messages);
        }
    }
}