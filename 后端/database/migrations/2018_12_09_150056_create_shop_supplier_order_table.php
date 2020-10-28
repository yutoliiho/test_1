<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSupplierOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_supplier_order', function (Blueprint $table) {
            $table->increments('id')->comment('编号');

            $table->integer('orderID')->comment('订单ID');
            $table->integer('pID')->comment('产品ID');
            $table->integer('dataID')->comment('订单数据ID');
            $table->string('data')->comment('执行数据');
            $table->integer('supID')->comment('执行数据供应商');
            $table->string('supOrderID')->comment('供应商订单');
            $table->string('supOrderStatus')->comment('供应商状态');

            $table->integer('startEmail')->default(0)->comment('订单创建邮件');
            $table->integer('endEmail')->default(0)->comment('订单完成邮件');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_supplier_order AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_supplier_order');
    }
}
