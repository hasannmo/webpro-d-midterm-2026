<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroBanner = 'hero-banner.jpeg';

        $heroSlides = [
            [
                'image' => asset('images/' . $heroBanner),
                'alt' => 'mijusan hero banner',
                'href' => '#',
            ],
        ];

        $heroCards = [
            'hero-1.png',
            'hero-2.png',
            'hero-3.png',
            'hero-4.jpeg',
        ];

        $heroCardItems = array_map(function ($image, $index) {
            return [
                'image' => asset('images/' . $image),
                'alt' => 'Lookbook ' . ($index + 1),
                'href' => '#',
            ];
        }, $heroCards, array_keys($heroCards));

        $popularDb = Product::where('category', 'popular')
            ->orWhereIn('slug', [
                'black-blazer',
                'cotton-peplum-top',
                'knit-cardigan-long-sleeve-sweater-loose-fit-candy',
                'long-denim-pants-regular-fit-jeans-cotton-arumi',
                't-shirt-short-sleeve-regular-fit-cotton-nanami',
                'bomber-jacket-regular-fit-polyester-reygan',
                'long-straight-denim-pants-loose-fit-jeans-cotton-cassie',
                'h-line-skirt-front-pocket-corduroy-marigold',
            ])
            ->latest()
            ->take(8)
            ->get();

        $topWearDb = Product::where('category', 'top')->latest()->take(10)->get();
        $outerWearDb = Product::where('category', 'outer')->latest()->take(10)->get();
        $bottomWearDb = Product::where('category', 'bottom')->latest()->take(10)->get();

        $formatProducts = function ($products) {
            return $products->map(function ($product) {
                return [
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image_url,
                    'secondImage' => $product->second_image_url,
                    'href' => route('product.show', ['productName' => $product->slug]),
                ];
            })->all();
        };

        return view('home', [
            'heroBanner' => $heroBanner,
            'heroSlides' => $heroSlides,
            'heroCards' => $heroCards,
            'heroCardItems' => $heroCardItems,
            'popularProducts' => $formatProducts($popularDb),
            'topWearProducts' => $formatProducts($topWearDb),
            'outerWearProducts' => $formatProducts($outerWearDb),
            'bottomWearProducts' => $formatProducts($bottomWearDb),
        ]);
    }
}
