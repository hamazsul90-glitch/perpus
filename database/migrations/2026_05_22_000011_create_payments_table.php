<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->string('method')->nullable(); // 'cash' or 'qris'
            $table->string('status')->default('pending'); // pending, paid
            $table->timestamp('paid_at')->nullable();
            $table->text('qris_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
