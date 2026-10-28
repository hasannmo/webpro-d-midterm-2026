<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $products = Product::whereIn('slug', [
            'black-blazer',
            'cotton-peplum-top',
            'knit-cardigan-long-sleeve-sweater-loose-fit-candy',
            'long-denim-pants-regular-fit-jeans-cotton-arumi',
            't-shirt-short-sleeve-regular-fit-cotton-nanami',
            'bomber-jacket-regular-fit-polyester-reygan',
            'long-straight-denim-pants-loose-fit-jeans-cotton-cassie',
            'h-line-skirt-front-pocket-corduroy-marigold',
        ])->get();

        if ($products->isEmpty()) {
            $products = Product::take(8)->get();
        }

        $wishlistItems = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'secondImage' => $product->second_image_url,
                'href' => route('product.show', ['productName' => $product->slug]),
            ];
        })->all();

        return view('wishlist', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}
