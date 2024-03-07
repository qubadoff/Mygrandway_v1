<?php

use App\Enums\DriverStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('drivers', function (Blueprint $table) {

            $table->id();
            $table->string('full_name');
            $table->string('phone')->unique();
            $table->string('password');

            $table->string('country_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('about')->nullable();

            $table->string('driver_license_no')->nullable();

            $table->integer('truck_type_id')->index();

            $table->string('latitude',50)->nullable();
            $table->string('longitude',50)->nullable();

            $table->text('fcm_token')->nullable();

            $table->text('business_code')->nullable();

            $table->tinyInteger('status')->default(
                DriverStatus::PENDING->value
            );

            $table->timestamp('phone_verified_at')->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->index(['latitude', 'longitude']);

            //add index to location column

        });

//        DB::statement('ALTER TABLE drivers ADD SPATIAL INDEX(location)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
