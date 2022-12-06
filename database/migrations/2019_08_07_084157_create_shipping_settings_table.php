<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('country_id')->nullable();
            $table->string('country_name')->nullable();
            $table->string('state_id')->nullable();
            $table->string('state_name')->nullable();
            $table->tinyInteger('shipping_zone')->comment('0 - Country Zone, 1 - State Zone, 2 - Rest Of The World')->default(0);
            $table->tinyInteger('status')->comment('0 - InActive, 1 - Active')->default(1);
            $table->json('value')->nullable();
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
        Schema::dropIfExists('shipping_settings');
    }
}
