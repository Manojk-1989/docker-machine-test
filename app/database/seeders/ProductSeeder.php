<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'The most powerful MacBook Pro ever with M3 chip, 16-inch Liquid Retina XDR display, and all-day battery life.',
                'category' => 'Electronics',
                'price' => 2499.99,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The iPhone 15 Pro features a titanium design, A17 Pro chip, and advanced camera system with 5x telephoto zoom.',
                'category' => 'Electronics',
                'price' => 999.99,
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise canceling headphones with exceptional sound quality and 30-hour battery life.',
                'category' => 'Electronics',
                'price' => 349.99,
            ],
            [
                'name' => 'Samsung 55" QLED 4K TV',
                'description' => 'Quantum Dot technology delivers brilliant colors and exceptional contrast with smart TV capabilities.',
                'category' => 'Electronics',
                'price' => 1299.99,
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Revolutionary Air unit provides all-day comfort with a modern design and durable construction.',
                'category' => 'Footwear',
                'price' => 150.00,
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'Energy-returning running shoes with Boost midsole technology for maximum comfort and performance.',
                'category' => 'Footwear',
                'price' => 180.00,
            ],
            [
                'name' => 'Instant Pot Duo 7-in-1',
                'description' => 'Multi-use programmable pressure cooker with 7 cooking functions and 14 built-in safety mechanisms.',
                'category' => 'Home & Kitchen',
                'price' => 89.99,
            ],
            [
                'name' => 'KitchenAid Stand Mixer',
                'description' => 'Professional 5-quart bowl-lift stand mixer with 10 speeds and multiple attachments included.',
                'category' => 'Home & Kitchen',
                'price' => 379.99,
            ],
            [
                'name' => 'LEGO Creator Expert Set',
                'description' => 'Advanced building set for adults featuring intricate details and realistic functions.',
                'category' => 'Toys & Games',
                'price' => 149.99,
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Enhanced gaming console with vibrant OLED screen, improved audio, and 64GB internal storage.',
                'category' => 'Electronics',
                'price' => 349.99,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
