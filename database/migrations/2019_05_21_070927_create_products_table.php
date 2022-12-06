<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->integer('brand_id');
            $table->string('sku');
            // $table->string('UPC')->comment('Universal Product Code');
            // $table->string('MPN')->comment('Manufacturer Part Number');
            // $table->string('GTN')->comment('Global Trade Number');
            // $table->string('BPN')->comment('Bin Picking Number');
            $table->decimal('price', 8, 2);
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            //$table->tinyInteger('sort_order');
            $table->decimal('weight', 10, 2)->comment('KGS');
            $table->decimal('depth', 10, 2)->nullable()->comment('inches');
            $table->decimal('width', 10, 2)->nullable()->comment('inches');
            $table->decimal('height', 10, 2)->nullable()->comment('inches');
            $table->json('category_id')->nullable();
            $table->json('video_id')->nullable();
            $table->json('youtube_url')->nullable();
            $table->json('attribute_id')->nullable();
            $table->json('attribute_option_id')->nullable();
            $table->tinyInteger('inventory_tracking')->comment('1 - Yes, 0 - No')->default(0);
            $table->tinyInteger('inventory_tracking_by')->comment('0 - On the product level, 1 - On the attribute level')->default(0);
            $table->integer('quantity')->nullable();
            $table->integer('low_stock')->nullable();
            $table->tinyInteger('mark_as_new')->comment('1 - Yes, 0 - No')->default(0);
            $table->tinyInteger('mark_as_featured')->comment('1 - Yes, 0 - No')->default(0);
            $table->json('custom_fields')->nullable();
            $table->integer('tax_class_id')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_tag_keywords')->nullable();
            $table->text('meta_tag_description')->nullable();
            $table->tinyInteger('status')->comment('0 - Save As Draft, 1 - Active')->default(1);
            $table->softDeletes();
            //$table->integer('viewed');
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
        Schema::dropIfExists('products');
    }
}
