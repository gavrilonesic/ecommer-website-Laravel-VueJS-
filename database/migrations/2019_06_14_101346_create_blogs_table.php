<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('blog_category_id')->nullable();
            $table->string('blog_category_name')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_tag_keywords')->nullable();
            $table->text('meta_tag_description')->nullable();
            $table->tinyInteger('status')->comment('0 - Draft, 1 - Publish')->default(1);
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
        Schema::dropIfExists('blogs');
    }
}
