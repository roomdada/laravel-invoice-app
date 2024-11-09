<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       \App\Models\Role::create(['name' => 'Customer']);
        User::create([
            'name' => 'Moussa',
            'email' => 'moussa@email.com',
            'role_id' => Role::first()->id,
            'password' => bcrypt('password')
        ]);

        $products = ['Laravel 7', 'Laravel 8', 'Laravel 9', 'Laravel 10'];
        foreach($products as $product) {
            Product::create([
                'name' => $product,
                'description' => 'description du produit ' . $product,
                'price' => rand(100, 1000)
            ]);
        }

        for($i=0; $i < 10; $i++) {
            \App\Models\Order::create([
                'reference' => 'ORD-' . time() . '-' . $i,
                'product_id' => Product::all()->random()->id,
                'user_id' => User::all()->random()->id,
                'quantity' => rand(1, 10)
            ]);
        }
    }
}
