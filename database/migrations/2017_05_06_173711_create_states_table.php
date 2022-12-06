<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->mediumInteger('id')->index()->primary();
            $table->string('name', 100);
            $table->mediumInteger('country_id');
            $table->char('country_code', 2);
            $table->string('state_code');
            $table->timestamps();
            $table->softDeletes();
        });
        // Schema::table('countries', function ($table) {
        //     $table->foreign('country_id')->references('id')->on('countries');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
