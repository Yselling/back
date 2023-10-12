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
        // Create 100 users, and their carts
        User::factory(100)->create()->each(function ($user) {
            $user->cart()->save(Cart::factory()->make());
        });

        // Create 100 products, and each product belongs to a category, and has 1-5 images
        Product::factory(100)->create()->each(function ($product) {
            $product->category()->associate(Category::inRandomOrder()->first())->save();
            $product->medias()->saveMany(Media::factory()->count(rand(1, 5))->make());
        });

        // For each cart, create 1-10 Order records, but only one Order should have a status of 'clear', and the rest should be 'paid'
        Cart::all()->each(function ($cart) {
            $cart->orders()->saveMany(Order::factory()->count(rand(1, 10))->make());
            $cart->orders()->first()->update([
                'state' => 'clear',
            ]);
        });

        // For each Order, create 1-10 OrderProduct records
        Order::all()->each(function ($order) {
            $order->orderProducts()->saveMany(OrderProduct::factory()->count(rand(1, 10))->make());
        });
    }
}
