<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderItemsAddCarrierName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function(Blueprint $table) {
        	$table->string('carrier_name')->nullable()->after('tracking_provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('order_items', function(Blueprint $table) {
		    $table->drop('carrier_name');
	    });
    }
}
