<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSupplierListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_supplier_list', function (Blueprint $table) {
            $table->increments('id')->comment('编号');

            $table->string('url')->nullable()->comment('API地址');
            $table->string('key')->nullable()->comment('API密钥');
            $table->string('balance')->default(0.00)->comment('API余额');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_supplier_list AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_supplier_list');
    }
}
