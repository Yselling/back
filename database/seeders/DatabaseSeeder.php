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
        $this->call(RoleSeeder::class);



    }
}
