<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('author');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('review_title');
            $table->text('review_description');
            $table->tinyInteger('rating')->comment('0 - poor, 1 - below average, 2 - average, 3 - average, 4 - good, 5 - excellent');
            $table->tinyInteger('status')->comment('0 - pending, 1 - approved, 2 - disapproved')->default(0);
            $table->date('publish_date')->nullable();
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
