<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->increments('id')->comment('主键');

            $table->integer('parent_id')->default(0)->comment('父分类ID');
            $table->bigInteger('order')->default(0)->comment('排序');
            $table->string('title')->default('分类名')->comment('分类名');

            $table->string('image')->comment('分类图片');
            $table->string('description')->comment('分类描述');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_categories AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_categories');
    }
}
