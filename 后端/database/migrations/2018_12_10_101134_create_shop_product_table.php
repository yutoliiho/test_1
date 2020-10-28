<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product', function (Blueprint $table) {
            $table->increments('id')->comment("编号");

            $table->integer('cid')->comment('分类');
            $table->text('name')->comment('商品名');
            $table->text('description')->comment('介绍');
            $table->decimal('price')->comment('单价');
            $table->text('data')->comment('产品数据');
            $table->integer('isDisable')->comment('是否下架');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_product AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product');
    }
}
