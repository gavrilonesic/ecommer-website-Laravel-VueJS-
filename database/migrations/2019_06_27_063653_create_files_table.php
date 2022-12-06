<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 100)->index(); //csv, report
            $table->longText('content')->nullable();
            $table->boolean('is_queued')->default(0)->index();
            $table->dateTime('scheduled_at')->nullable()->index();
            $table->dateTime('done_at')->nullable()->index();
            $table->boolean('is_working')->default(0)->index();
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
        Schema::dropIfExists('files');
    }
}
