<?php

namespace Database\Factories;

use App\Models\TruckType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TruckType>
 */
class TruckTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'status' => 'active'
        ];
    }
}
