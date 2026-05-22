<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dateTime('due_at')->nullable()->after('borrowed_at');
            $table->boolean('is_overdue')->default(false)->after('due_at');
            $table->decimal('fee', 8, 2)->nullable()->after('is_overdue');
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['due_at', 'is_overdue', 'fee']);
        });
    }
};
