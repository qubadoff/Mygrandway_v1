<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('driver_routes', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id')->index();
            $table->integer('from_city_id')->index();
            $table->integer('to_city_id')->index();

            $table->unique(['driver_id', 'from_city_id', 'to_city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_routes');
    }
};
