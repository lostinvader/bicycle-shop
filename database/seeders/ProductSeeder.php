<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['Bicycle'];

        $parts = [
            'Frame type' => [
                'Full-suspension',
                'Diamond',
                'Step-through',
            ], 'Frame finish' => [
                'Matte',
                'Shiny',
            ], 'Wheels' => [
                'Road',
                'Mountain',
                'Fat Bike',
            ], 'Rim color' => [
                'Red',
                'Black',
                'Blue',
            ], 'Chain' => [
                'Single-speed',
                '8-speed',
            ],
        ];

        $productId = DB::table('products')->insertGetId([
            'name' => 'Bicycle',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        foreach ($parts as $partName => $parts) {
            $partId = DB::table('parts')->insertGetId([
                'name' => $partName,
                'product_id' => $productId,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            foreach ($parts as $part) {
                DB::table('variants')->insert(
                    ['name' => $part,
                        'default_price_amount' => fake()->numberBetween(30, 200),
                        'stock' => fake()->numberBetween(1, 20),
                        'part_id' => $partId,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
            }
        }
    }
}
