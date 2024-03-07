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
        DB::unprepared(file_get_contents(database_path('sql/cities/chunk-1.sql')));
        //DB::unprepared(file_get_contents(database_path('sql/cities/chunk-2.sql')));
        //DB::unprepared(file_get_contents(database_path('sql/cities/chunk-3.sql')));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
