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
        Schema::create('billing_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('billing_id');
            $table->foreign('billing_id')->references('id')->on('billings')->onDelete('cascade');

            $table->unsignedBigInteger('billing_product_id');
            $table->foreign('billing_product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('billing_measurement')->nullable();
            $table->string('billing_qty')->nullable();
            $table->string('billing_rateperqty')->nullable();
            $table->string('billing_total')->nullable();

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
        Schema::dropIfExists('billing_products');
    }
};
