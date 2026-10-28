<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));

        $products = collect();

        if ($query !== '') {
            $products = Product::where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })->latest()->get();
        }

        $items = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'secondImage' => $product->second_image_url,
                'href' => route('product.show', ['productName' => $product->slug]),
            ];
        })->all();

        return view('search', [
            'query' => $query,
            'items' => $items,
            'count' => $products->count(),
        ]);
    }
}

