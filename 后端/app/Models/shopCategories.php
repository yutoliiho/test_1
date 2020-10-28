<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

/**
 * @method static where(string $columnName, string $Where, string $Value)
 */
class shopCategories extends Model
{
    use ModelTree, AdminBuilder;
    protected $table = "shop_categories";
}
