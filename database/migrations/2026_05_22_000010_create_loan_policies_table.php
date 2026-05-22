<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loan_policies', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_days')->default(14);
            $table->integer('loan_fee')->default(0); // nominal when borrowing
            $table->integer('late_fee_per_day')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_policies');
    }
};
