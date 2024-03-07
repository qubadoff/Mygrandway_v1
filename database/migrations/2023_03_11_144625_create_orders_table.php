<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('driver_id')->nullable()->index();
            $table->integer('from_city_id')->index();
            $table->integer('to_city_id')->index();
            $table->integer('truck_type_id')->nullable();
            $table->string('status', 50)->index()->default(
                OrderStatus::Pending->value
            );
            $table->timestamp('pickup_at')->nullable();
            $table->timestamp('dropoff_at')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->mediumText('meta')->nullable();
            $table->integer('price')->nullable();
            $table->float('currency_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
