<?php

namespace Database\Factories;

use App\Enums\DriverStatus;
use App\Models\Country;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => 123456,
            'country_id' => 16, //Azerbaijan
            'city_id' => 8052, //Baku
            'address' => $this->faker->address,
            'about' => null,
            'location' => new Point($this->faker->latitude, $this->faker->longitude),
            'driver_license_no' => $this->faker->randomNumber(8),
            'truck_type_id' => 1,
            'fcm_token' => null,
            'status' => DriverStatus::APPROVED,
            'phone_verified_at' => now(),
            'routes' => [
                [
                    'from_city_id' => 8052,
                    'to_city_id' => 8053,
                ]
            ]
        ];
    }
}
