<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->bigInteger('user_id');
            $table->string('invoice_no', 50);
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();;
            $table->string('mobile_no', 20)->nullable();
            $table->string('shipping_address_1');
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_address_name')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_country');
            $table->string('shipping_postcode');
            $table->string('shipping_quotes')->nullable();
            $table->string('store_address')->nullable();
            $table->bigInteger('shipping_setting_id')->nullable();
            $table->string('shipping_service_name', 255)->nullable();
            $table->string('shipping_account_number', 255)->nullable();
            $table->text('shipping_note')->nullable();
            $table->string('billing_first_name');
            $table->string('billing_last_name')->nullable();
            $table->string('billing_email')->nullable();;
            $table->string('billing_mobile_no', 20)->nullable();
            $table->string('billing_address_1');
            $table->string('billing_address_2')->nullable();
            $table->string('billing_address_name')->nullable();
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_country');
            $table->string('billing_postcode');
            $table->integer('payment_setting_id');
            $table->boolean('payment_status')->nullable();
            $table->integer('payment_status_code')->nullable();
            $table->string('payment_message')->nullable();
            $table->string('payment_transaction_id',25)->nullable();
            $table->json('payment_response')->nullable();
            $table->text('comment')->nullable();
            $table->integer('order_status_id');
            $table->string('currency_id', 50)->nullable();
            $table->string('currency_code', 50)->nullable();
            $table->string('currency_value', 50)->nullable();
            $table->decimal('order_total', 8, 2);
            $table->decimal('order_sub_total', 8, 2);
            $table->decimal('shipping_total', 8, 2)->nullable();
            $table->decimal('tax_total', 8, 2)->nullable();
            $table->decimal('refund_total', 8, 2)->nullable();
            $table->decimal('order_discount', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
