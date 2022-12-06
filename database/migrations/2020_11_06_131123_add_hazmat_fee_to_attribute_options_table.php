<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHazmatFeeToAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_options', function (Blueprint $table) {
            $table->decimal('hazmat_fee', 10, 2)->after('slug')->default(config('constants.hazmat_shipping_cost'))->nullable();
            $table->decimal('ltl_multiplier', 10, 2)->after('slug')->default(1)->nullable();
            $table->decimal('ltl_fee', 10, 2)->after('slug')->default(config('constants.ltl_hazmat_shipping_cost'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_options', function (Blueprint $table) {
            $table->dropColumn(['hazmat_fee', 'ltl_fee', 'ltl_multiplier']);
        });
    }
}
