<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('parent_id');
            $table->string('name');
            $table->string('slug');
            $table->integer('level');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('template_layout', 100)->default('default');
            $table->tinyInteger('sort_order')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_tag_keywords')->nullable();
            $table->text('meta_tag_description')->nullable();
            $table->tinyInteger('status')->comment('0 - InActive, 1 - Active')->default(1);
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
        Schema::dropIfExists('categories');
    }
}
