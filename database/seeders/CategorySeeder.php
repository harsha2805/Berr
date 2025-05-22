<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vases',
                'description' => 'Elegant and modern vases to decorate your living space.',
                'image_path' => 'public/images/icons/white-vase.webp',
                'dark_image_path' => 'public/images/icons/black-vase.webp',
                'dark_icon_class' => '',
                'icon_class' => '',
            ],
            [
                'name' => 'Candles',
                'description' => 'Scented and decorative candles perfect for ambiance and relaxation.',
                'image_path' => 'public/images/icons/white-lotus-candle.webp',
                'dark_image_path' => 'public/images/icons/black-lotus-candle.webp',
                'dark_icon_class' => '',
                'icon_class' => '',
            ],
            [
                'name' => 'Flowers',
                'description' => 'Fresh and artificial flower arrangements for all occasions.',
                'image_path' => '',
                'dark_image_path' => '',
                'dark_icon_class' => 'fas fa-seedling',
                'icon_class' => 'fas fa-seedling',
            ],
            [
                'name' => 'Wall Arts',
                'description' => 'Unique wall art pieces to elevate your home décor.',
                'image_path' => '',
                'dark_image_path' => '',
                'dark_icon_class' => 'fas fa-image',
                'icon_class' => 'fas fa-image',
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image_path' => $category['image_path'],
                'dark_image_path' => $category['dark_image_path'],
                'dark_icon_class' => $category['dark_icon_class'],
                'icon_class' => $category['icon_class'],
            ]);
        }
    }
}
