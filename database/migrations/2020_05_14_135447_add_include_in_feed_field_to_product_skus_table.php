<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncludeInFeedFieldToProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_skus', function (Blueprint $table) {
            $table->tinyInteger('include_in_feed')->nullable()->default(1);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('include_in_feed')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_skus', function (Blueprint $table) {
            $table->dropColumn('include_in_feed');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('include_in_feed');
        });
    }
}
