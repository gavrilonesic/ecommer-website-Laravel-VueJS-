<?php

use App\ProductSku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHazmatTypeToProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_skus', function (Blueprint $table) {
            $table->tinyInteger('hazmat_type')->default(ProductSku::HAZMAT_TYPE_NONE)->after('is_hazmat');
        });
        
        ProductSku::where('is_hazmat', 1)->update(['hazmat_type' => ProductSku::HAZMAT_TYPE_ALL]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_skus', function (Blueprint $table) {
            $table->dropColumn('hazmat_type');
        });
    }
}
