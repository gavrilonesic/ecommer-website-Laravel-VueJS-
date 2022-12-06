<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('view');
            $table->string('description');
            $table->string('is_free')->comment('0 - No, 1 - Yes')->default(0);
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
        Schema::dropIfExists('shipping_quotes');
    }
}
