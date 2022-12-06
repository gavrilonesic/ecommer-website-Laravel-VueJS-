<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->string('link')->nullable();
            $table->tinyInteger('type')->comment('0 - Small Width, 1 - Full Width')->default(0);
            $table->tinyInteger('position')->comment('0 - Top, 1 - Left')->default(0);
            $table->string('show_on_page');
            $table->tinyInteger('display_in_all_page')->default(0);
            $table->integer('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->tinyInteger('date_range_option')->comment('0 - Specific Dates, 1 - I remove it')->default(1);
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->tinyInteger('visibility')->comment('0 - no, 1 - yes')->default(1);
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
        Schema::dropIfExists('banners');
    }
}
