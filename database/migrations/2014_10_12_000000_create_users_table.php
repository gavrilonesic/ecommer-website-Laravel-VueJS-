<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('mobile_no', 20)->nullable();
            $table->string('authorized_dot_net_user_id', 50)->nullable();
            $table->string('shipping_service_name', 255)->nullable();
            $table->string('shipping_account_number', 255)->nullable();
            $table->text('shipping_note')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_guest')->comment('0 - No, 1 - Yes')->default(0);
            $table->string('otp', 15)->nullable();
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
        Schema::dropIfExists('users');
    }
}
