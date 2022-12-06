<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductSkus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_skus', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('product_id');
            $table->string('sku')->nullable();
            $table->json('attribute_option_id')->nullable();
            $table->decimal('weight', 10, 2)->nullable()->comment('KGS');
            $table->decimal('depth', 10, 2)->nullable()->comment('inches');
            $table->decimal('height', 10, 2)->nullable()->comment('inches');
            $table->decimal('width', 10, 2)->nullable()->comment('inches');
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->nullable();
            $table->integer('low_stock')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_skus');
    }
}
