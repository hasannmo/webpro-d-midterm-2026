<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Map of available catalog products.
     */
    protected array $products = [
        'basic-shirt-short-sleeve' => [
            'name' => 'Basic Shirt Short Sleeve',
            'price' => 99999,
            'image' => 'basic-shirt-short-sleeve.png',
        ],
        'black-blazer' => [
            'name' => 'Black Blazer',
            'price' => 299000,
            'image' => 'black-blazer.png',
        ],
        'cotton-peplum-top' => [
            'name' => 'Cotton Peplum Top',
            'price' => 199000,
            'image' => 'cotton-peplum-top.png',
        ],
        'knit-cardigan-long-sleeve-sweater-loose-fit-candy' => [
            'name' => 'Knit Cardigan Long Sleeve Sweater Loose Fit Candy',
            'price' => 249000,
            'image' => 'knit-cardigan-long-sleeve-sweater-loose-fit-candy.png',
        ],
        'long-denim-pants-regular-fit-jeans-cotton-arumi' => [
            'name' => 'Long Denim Pants Regular Fit Jeans Cotton Arumi',
            'price' => 319000,
            'image' => 'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
        ],
        't-shirt-short-sleeve-regular-fit-cotton-nanami' => [
            'name' => 'T Shirt Short Sleeve Regular Fit Cotton Nanami',
            'price' => 149000,
            'image' => 't-shirt-short-sleeve-regular-fit-cotton-nanami.png',
        ],
        'bomber-jacket-regular-fit-polyester-reygan' => [
            'name' => 'Bomber Jacket Regular Fit Polyester Reygan',
            'price' => 379000,
            'image' => 'bomber-jacket-regular-fit-polyester-reygan.png',
        ],
        'long-straight-denim-pants-loose-fit-jeans-cotton-cassie' => [
            'name' => 'Long Straight Denim Pants Loose Fit Jeans Cotton Cassie',
            'price' => 329000,
            'image' => 'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
        ],
        'h-line-skirt-front-pocket-corduroy-marigold' => [
            'name' => 'H Line Skirt Front Pocket Corduroy Marigold',
            'price' => 269000,
            'image' => 'h-line-skirt-front-pocket-corduroy-marigold.png',
        ],
        'fine-knit-polo-neck' => [
            'name' => 'Fine Knit Polo Neck',
            'price' => 219000,
            'image' => 'fine-knit-polo-neck.png',
        ],
        'crew-neck' => [
            'name' => 'Crew Neck',
            'price' => 169000,
            'image' => 'crew-neck.png',
        ],
        'striped-shirt' => [
            'name' => 'Striped Shirt',
            'price' => 229000,
            'image' => 'striped-shirt.png',
        ],
        'regular-tshirt' => [
            'name' => 'Regular T Shirt',
            'price' => 129000,
            'image' => 'regular-tshirt.png',
        ],
        'dark-turquoise-nylon-windbreaker' => [
            'name' => 'Dark Turquoise Nylon Windbreaker',
            'price' => 349000,
            'image' => 'dark-turquoise-nylon-windbreaker.png',
        ],
        'collared-jacket' => [
            'name' => 'Collared Jacket',
            'price' => 399000,
            'image' => 'collared-jacket.png',
        ],
        'pile-lined-fleece-blouson' => [
            'name' => 'Pile Lined Fleece Blouson',
            'price' => 359000,
            'image' => 'pile-lined-fleece-blouson.png',
        ],
        'black-cardigan' => [
            'name' => 'Black Cardigan',
            'price' => 239000,
            'image' => 'black-cardigan.png',
        ],
        'black-long-cat' => [
            'name' => 'Black Long Coat',
            'price' => 459000,
            'image' => 'black-long-cat.png',
        ],
        'long-jogger-pants-relaxed-fit-drawstring-frenzy' => [
            'name' => 'Long Jogger Pants Relaxed Fit Drawstring Frenzy',
            'price' => 259000,
            'image' => 'long-jogger-pants-relaxed-fit-drawstring-frenzy.png',
        ],
        'long-denim-pants-regular-fit-cotton-casey' => [
            'name' => 'Long Denim Pants Regular Fit Cotton Casey',
            'price' => 309000,
            'image' => 'long-denim-pants-regular-fit-cotton-casey.png',
        ],
        'long-chino-pants-regular-fit-ferrero' => [
            'name' => 'Long Chino Pants Regular Fit Ferrero',
            'price' => 279000,
            'image' => 'long-chino-pants-regular-fit-ferrero.png',
        ],
        'midi-flare-skirt-babyterry-kasumi' => [
            'name' => 'Midi Flare Skirt Babyterry Kasumi',
            'price' => 219000,
            'image' => 'midi-flare-skirt-babyterry-kasumi.png',
        ],
    ];

    protected function resolveProduct(string $productName): array
    {
        $slug = Str::slug($productName);

        if (isset($this->products[$slug])) {
            return array_merge($this->products[$slug], ['slug' => $slug]);
        }

        foreach ($this->products as $key => $data) {
            if ($key === $productName || Str::slug($data['name']) === $slug) {
                return array_merge($data, ['slug' => $key]);
            }
        }

        return [
            'slug' => $slug,
            'name' => Str::headline(str_replace('-', ' ', $productName)),
            'price' => 99999,
            'image' => 'basic-shirt-short-sleeve.png',
        ];
    }

    public function show(string $productName): View
    {
        $product = $this->resolveProduct($productName);
        $confirmed = session('checkout_confirmed_' . $product['slug'], false);

        return view('checkout', [
            'product' => [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => asset('images/' . $product['image']),
                'slug' => $product['slug'],
            ],
            'confirmed' => $confirmed,
            'confirmAction' => route('checkout.confirm', ['productName' => $product['slug']]),
            'cancelHref' => route('product.show', ['productName' => $product['slug']]),
        ]);
    }

    public function confirm(string $productName): RedirectResponse
    {
        $product = $this->resolveProduct($productName);
        session()->flash('checkout_confirmed_' . $product['slug'], true);

        return redirect()->route('checkout.show', ['productName' => $product['slug']])
            ->with('status', 'Your checkout has been confirmed!');
    }
}

