<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('mobile_no', 20)->nullable();;
            $table->tinyInteger('billing_type')->comment('0 - billing, 1 - Shipping')->default(1);
            $table->string('address_name')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city_name', 255);
            $table->integer('state_id')->nullable();
            $table->string('state_name', 255)->nullable();
            $table->integer('country_id');
            $table->string('zip_code');
            $table->tinyInteger('address_type')->comment('0 - Residential, 1 - Commercial')->default(1);
            $table->tinyInteger('primary_address')->comment('0 - nonprimary, 1 - Primary')->default(0);
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
        Schema::dropIfExists('user_addresses');
    }
}
