<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $columnName, string $Where, string $Value)
 */
class shopProduct extends Model
{
    protected $table = "shop_product";

    public function getDataAttribute($value)
    {
        return explode(',', $value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = implode(',', $value);
    }
}
