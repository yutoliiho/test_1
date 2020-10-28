<?php
namespace App\OpenAPI\Web\Pay;

use App\OpenAPI\BaseController;
use Illuminate\Http\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Log;

class ReturnPaypal extends BaseController
{
    public function index(Request $request)
    {
        $this->logs(json_encode($request->header()));
        $this->logs(json_encode($request->all()));
        $pay = new Pay();
        try {
            if ($pay->callback()) {
                $this->logs("验证通过");


            } else {
                $this->logs("验证失败");
            }
        } catch (\Exception $exception) {
            $this->logs($exception->getMessage());
        }
    }

    protected function logs($messages)
    {
        $log = new Logger("PayCenter");

        $logDir = storage_path('logs/pay');
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        try {
            $log->pushHandler(new StreamHandler($logDir . '/' . date('Y-m-d') . '-return.log', Logger::INFO));
            $log->info($messages);
        } catch (\Exception $exception) {
            Log::info($messages);
        }
    }
}