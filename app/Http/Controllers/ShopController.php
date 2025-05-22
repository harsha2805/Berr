<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index()
    {
        // 1. Fetch all categories (even if empty)
        $categories = Category::select('id', 'name', 'slug', 'icon_class', 'dark_icon_class', 'image_path', 'dark_image_path')
            ->orderBy('name')
            ->get();

        // 2. Get all products with categories
        $products = Product::whereNull('deleted_at')
            ->with('category:id,name,slug') // eager load only required fields
            ->select('id', 'name', 'slug as product_slug', 'category_id', 'description', 'price', 'stock', 'image_path')
            ->get();

        // 3. Group products by category slug
        $grouped = $products->groupBy(fn($p) => $p->category?->slug ?? 'uncategorized')
            ->map(function ($group) {
                $first = $group->first();
                return [
                    'name' => $first->category?->name ?? 'Uncategorized',
                    'products' => $group
                ];
            })
            ->sortBy('name');


        // 4. Pass both categories and grouped products to view
        return view('shop.index', [
            'categories' => $categories,
            'groupedProducts' => $grouped
        ]);
    }

}
