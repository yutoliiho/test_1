<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order', function (Blueprint $table) {
            $table->increments('id')->comment('编号');

            $table->string('orderId')->comment('订单号');
            $table->integer('pId')->comment('产品信息');
            $table->integer('count')->comment('购买数量');
            $table->decimal('aPrice')->comment('购买单价');
            $table->decimal('bPrice')->comment('购买总价');
            $table->string('email')->comment('购买邮箱');
            $table->text('data')->comment('账号信息');
            $table->integer('payHas')->comment('是否支付');
            $table->string('payName')->comment('支付平台')->nullable();
            $table->string('payOrder')->comment('支付ID')->nullable();
            $table->timestamp('payTime')->comment('支付时间');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_order AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order');
    }
}
