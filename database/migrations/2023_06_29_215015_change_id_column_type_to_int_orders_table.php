<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('orders')->truncate();
        Schema::table('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
        });

        DB::table('messages')->truncate();
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
        });

        DB::table('notifications')->truncate();
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
