<?php

namespace Database\Seeders;

use App\Models\OrderState;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'clear',
            'paid',
            'shipped',
            'delivered',
            'returned',
        ];

        foreach ($states as $state) {
            OrderState::create([
                'name' => $state,
            ]);
        }
    }
}
