<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlistImages = [
            'black-blazer.png',
            'cotton-peplum-top.png',
            'knit-cardigan-long-sleeve-sweater-loose-fit-candy.png',
            'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
            't-shirt-short-sleeve-regular-fit-cotton-nanami.png',
            'bomber-jacket-regular-fit-polyester-reygan.png',
            'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
            'h-line-skirt-front-pocket-corduroy-marigold.png',
        ];

        $wishlistItems = array_map(function ($image) {
            $base = pathinfo($image, PATHINFO_FILENAME);
            $name = Str::headline(str_replace('-', ' ', $base));

            return [
                'name' => $name,
                'price' => 299000,
                'image' => asset('images/' . $image),
                'secondImage' => asset('images/' . $image),
                'href' => route('product.show', ['productName' => $base]),
            ];
        }, $wishlistImages);

        return view('wishlist', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}

