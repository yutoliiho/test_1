<?php
namespace App\OpenAPI;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    use Helpers;

    public function reCode200($data){
        return [
            "status_code"=> 200,
            "data"=> $data,
        ];
    }

    public function reError500($messages){
        return [
            "status_code"=> 500,
            "message"=> $messages,
        ];
    }

    public function arrayInSort($arrays, $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC)
    {
        if (is_array($arrays)) {
            foreach ( $arrays as $array ) {
                if (is_array($array)) {
                    $key_arrays[] = $array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }

    public function hasDatabases($model,$column,$value){
        if (isset($value)){
            $list = $model->where($column,"=",$value)->get([$column])->toArray();
            if (count($list) != 0 ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


}