<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'heroBanner' => 'hero-banner.jpeg',

            'heroCards' => [
                'hero-1.png',
                'hero-2.png',
                'hero-3.png',
                'hero-4.jpeg',
            ],

            'popular' => [
                'black-blazer.png',
                'cotton-peplum-top.png',
                'knit-cardigan-long-sleeve-sweater-loose-fit-candy.png',
                'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
                't-shirt-short-sleeve-regular-fit-cotton-nanami.png',
                'bomber-jacket-regular-fit-polyester-reygan.png',
                'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
                'h-line-skirt-front-pocket-corduroy-marigold.png',
            ],

            'topWear' => [
                'fine-knit-polo-neck.png',
                'basic-shirt-short-sleeve.png',
                'crew-neck.png',
                'cotton-peplum-top.png',
                'striped-shirt.png',
                'regular-tshirt.png',
            ],

            'outerWear' => [
                'dark-turquoise-nylon-windbreaker.png',
                'collared-jacket.png',
                'pile-lined-fleece-blouson.png',
                'black-blazer.png',
                'black-cardigan.png',
                'black-long-cat.png',
            ],

            'bottomWear' => [
                'long-jogger-pants-relaxed-fit-drawstring-frenzy.png',
                'long-denim-pants-regular-fit-cotton-casey.png',
                'long-chino-pants-regular-fit-ferrero.png',
                'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
                'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
                'midi-flare-skirt-babyterry-kasumi.png',
            ],
        ]);
    }
}
