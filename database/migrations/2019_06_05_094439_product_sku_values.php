<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductSkuValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sku_values', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('product_id');
            $table->integer('attribute_id');
            $table->integer('attribute_option_id');
            $table->bigInteger('product_sku_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sku_values');
    }
}
