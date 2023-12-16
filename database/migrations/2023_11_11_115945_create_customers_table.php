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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_key')->unique()->nullable();
            $table->boolean('soft_delete')->default(0);
            $table->string('name');
            $table->string('phonenumber')->nullable();
            $table->string('alter_phonenumber')->nullable();
            $table->string('email_id')->nullable();
            $table->string('address')->nullable();
            $table->string('source_from')->nullable();
            $table->longText('customer_photo')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('wedding_date')->nullable();

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            
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
        Schema::dropIfExists('customers');
    }
};
