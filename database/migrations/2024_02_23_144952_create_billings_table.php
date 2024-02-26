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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('unique_key')->unique();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('billno')->nullable();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->string('total_amount')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount')->nullable();
            $table->string('note')->nullable();
            $table->string('total_discountamount')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('total_paid_amount')->nullable();
            $table->string('total_balance_amount')->nullable();
            $table->string('status')->nullable();
            $table->boolean('soft_delete')->default(0);
            
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
        Schema::dropIfExists('billings');
    }
};
