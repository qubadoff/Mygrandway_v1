<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\TruckType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //TruckType::factory(5)->create();
         //Driver::factory(50)->create();

        Role::query()->updateOrCreate(['guard_name' => 'web','name' => 'Super']);

        $admin = Admin::first() ?? Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt(123456)
        ]);

        $admin->assignRole('Super');
    }
}
