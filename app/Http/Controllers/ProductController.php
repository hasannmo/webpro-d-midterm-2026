<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $productName): View|RedirectResponse
    {
        $slug = Str::slug($productName);

        $product = Product::where('slug', $slug)
            ->orWhere('id', $productName)
            ->orWhere('slug', $productName)
            ->first();

        if (!$product) {
            $product = Product::first();
        }

        $recommendations = Product::where('id', '!=', $product->id ?? 0)
            ->inRandomOrder()
            ->take(8)
            ->get();

        if ($recommendations->isEmpty()) {
            $recommendations = Product::take(8)->get();
        }

        $discoverProducts = $recommendations->map(function ($p) {
            return [
                'name' => $p->name,
                'price' => $p->price,
                'image' => $p->image_url,
                'secondImage' => $p->second_image_url,
                'href' => route('product.show', ['productName' => $p->slug]),
            ];
        })->all();

        return view('product-detail', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'secondImage' => $product->second_image_url,
                'description' => $product->description,
                'slug' => $product->slug,
            ],
            'discoverProducts' => $discoverProducts,
        ]);
    }
}
