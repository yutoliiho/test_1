<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSupplierDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_supplier_data', function (Blueprint $table) {
            $table->increments('id')->comment('编号');

            $table->string('title')->comment('数据标题');
            $table->text('data')->comment('数据内容');

            $table->timestamps();
        });
        DB::statement("ALTER TABLE shop_supplier_data AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_supplier_data');
    }
}
