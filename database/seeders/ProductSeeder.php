<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Elegant Glass Vase',
                'category' => 'Vases',
                'price' => 49.99
            ],
            [
                'name' => 'Scented Soy Candle',
                'category' => 'Candles',
                'price' => 19.99
            ],
            [
                'name' => 'Bouquet of Red Roses',
                'category' => 'Flowers',
                'price' => 29.99
            ],
            [
                'name' => 'Modern Wall Art Canvas',
                'category' => 'Wall Arts',
                'price' => 89.99
            ],
            [
                'name' => 'Rustic Ceramic Vase',
                'category' => 'Vases',
                'price' => 39.50
            ],
            [
                'name' => 'Lavender Aromatherapy Candle',
                'category' => 'Candles',
                'price' => 15.00
            ],
        ];

        foreach ($products as $prod) {
            $category = Category::where('name', $prod['category'])->first();

            if ($category) {
                Product::create([
                    'name' => $prod['name'],
                    'slug' => Str::slug($prod['name']),
                    'category_id' => $category->id,
                    'description' => fake()->sentence(),
                    'price' => $prod['price'],
                    'image_path' => 'public/images/img/candle1.webp',
                ]);
            }
        }
    }
}
