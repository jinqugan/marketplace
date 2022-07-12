<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable()->index();
            $table->string('email')->nullable();
            $table->string('order_no')->unique();
            $table->unsignedBigInteger('payment_method_id')->index();
            $table->unsignedBigInteger('stock_id')->index();
            $table->unsignedBigInteger('status_id')->index();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
