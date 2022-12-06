<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsShippingByAirColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_shipping_by_air')->nullable()->default(true)->after('is_hazmat');
        });

        Schema::table('product_skus', function (Blueprint $table) {
            $table->boolean('is_shipping_by_air')->nullable()->default(true)->after('is_hazmat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_shipping_by_air');
        });

        Schema::table('product_skus', function (Blueprint $table) {
            $table->dropColumn('is_shipping_by_air');
        });
    }
}
