<?php

namespace App\OpenAPI\Web\Auto\ins;

use App\OpenAPI\BaseController;
use InstagramScraper\Instagram;
use Illuminate\Http\Request;


class media extends BaseController
{
    public function index(Request $request)
    {
        if ($request->has('userName')) {
            $userName = trim($request->get('userName'));
            $instagram = new Instagram();
            if ($request->has('nextID')) {
                $maxId = $request->get('nextID');
                $data = $instagram->getPaginateMedias($userName, $maxId);
            } else {
                $data = $instagram->getPaginateMedias($userName);
            }
            $data['medias'] = $this->toArray($data['medias']);
            return $this->reCode200($data);
        } else {
            return $this->reError500("Username has not null.");
        }
    }


    public function toArray($object)
    {
        $data = (array) $object;
        foreach ($data as $prop => &$value) {
            if (\is_object($value)) {
                $value = $this->toArray($value);
            }
            if (strpos($prop, "\0") !== false) {
                unset($data[$prop]);
                $tmp         = explode("\0", $prop);
                $prop        = end($tmp);
                $data[$prop] = $value;
            }
        }
        return $data;
    }
}