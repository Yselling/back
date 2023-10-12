<?php

namespace Database\Seeders;


use App\Models\Category;
use App\Models\Gender;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(DevSeeder::class);
        $this->call(GenderSeeder::class);


        // Create 100 gender records
        Gender::factory(100)->create();

        // Create 2 roles
        $roles = ['admin', 'user'];
        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role,
            ]);
        }

        // Create 10 categories
        Category::factory(10)->create();

    }
}
