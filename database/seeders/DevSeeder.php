<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create a 100 of products
        Product::factory(100)->create()->each(function ($product) {
            $product->category()->associate(Category::inRandomOrder()->first());
            $product->medias()->saveMany(Media::factory()->count(rand(1, 5))->make());
        });

        User::factory()->create([
            'email' => 'user1@email.com',
            'password' => bcrypt('password'),
        ])->each(function ($user) {
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
        });

        // Create 100 users, and their carts
        User::factory(100)->create()->each(function ($user) {
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $user->cart()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
        });


        // For each cart, create 1-10 Order records, but only one Order should have a status of 'clear', and the rest should be 'paid'
        User::all()->each(function ($user) {
            $user->orders()->saveMany(Order::factory()->count(rand(1, 10))->make());
        });

        // For each Order, create 1-10 OrderProduct records
        Order::all()->each(function ($order) {
            $order->products()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $order->products()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
            $order->products()->attach(
                Product::inRandomOrder()->first(),
                ['amount' => rand(1, 10)]
            );
        });
    }
}
