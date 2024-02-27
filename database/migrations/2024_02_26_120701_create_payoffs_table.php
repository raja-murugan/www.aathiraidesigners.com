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
        Schema::create('payoffs', function (Blueprint $table) {
            $table->id();
            $table->string('unique_key')->unique();

            $table->string('date');
            $table->string('time');
            $table->string('month')->nullable();
            $table->string('year')->nullable();

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            
            $table->string('total_working_hour')->nullable();
            $table->string('perhoursalary')->nullable();
            $table->string('salaryamount')->nullable();
            $table->string('totalpaidsalary')->nullable();
            $table->string('balancesalary')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('payoffs');
    }
};
