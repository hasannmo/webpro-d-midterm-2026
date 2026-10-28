<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Map of available catalog products.
     */
    protected array $products = [
        'basic-shirt-short-sleeve' => [
            'name' => 'Basic Shirt Short Sleeve',
            'price' => 99999,
            'image' => 'basic-shirt-short-sleeve.png',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ],
        'black-blazer' => [
            'name' => 'Black Blazer',
            'price' => 299000,
            'image' => 'black-blazer.png',
            'description' => 'Timeless and versatile tailoring crafted from structured fabric. Designed with a clean silhouette that effortlessly transitions from formal meetings to evening leisure.',
        ],
        'cotton-peplum-top' => [
            'name' => 'Cotton Peplum Top',
            'price' => 199000,
            'image' => 'cotton-peplum-top.png',
            'description' => 'A feminine sleeveless top cut from soft cotton poplin with a flattering flared peplum waistline.',
        ],
        'knit-cardigan-long-sleeve-sweater-loose-fit-candy' => [
            'name' => 'Knit Cardigan Long Sleeve Sweater Loose Fit Candy',
            'price' => 249000,
            'image' => 'knit-cardigan-long-sleeve-sweater-loose-fit-candy.png',
            'description' => 'Charming crochet-knit loose fit cardigan, soft to the touch and perfect for breezy everyday layering.',
        ],
        'long-denim-pants-regular-fit-jeans-cotton-arumi' => [
            'name' => 'Long Denim Pants Regular Fit Jeans Cotton Arumi',
            'price' => 319000,
            'image' => 'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
            'description' => 'Classic five-pocket regular fit denim jeans tailored from durable pure cotton denim wash.',
        ],
        't-shirt-short-sleeve-regular-fit-cotton-nanami' => [
            'name' => 'T Shirt Short Sleeve Regular Fit Cotton Nanami',
            'price' => 149000,
            'image' => 't-shirt-short-sleeve-regular-fit-cotton-nanami.png',
            'description' => 'An essential regular-fit crew neck tee spun from premium heavyweight combed cotton.',
        ],
        'bomber-jacket-regular-fit-polyester-reygan' => [
            'name' => 'Bomber Jacket Regular Fit Polyester Reygan',
            'price' => 379000,
            'image' => 'bomber-jacket-regular-fit-polyester-reygan.png',
            'description' => 'Sporty everyday bomber jacket with a clean ribbed collar, smooth zip closure, and water-repellent finish.',
        ],
        'long-straight-denim-pants-loose-fit-jeans-cotton-cassie' => [
            'name' => 'Long Straight Denim Pants Loose Fit Jeans Cotton Cassie',
            'price' => 329000,
            'image' => 'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
            'description' => 'Relaxed loose-fit straight jeans with contrast turnover hems for an effortless streetwear edge.',
        ],
        'h-line-skirt-front-pocket-corduroy-marigold' => [
            'name' => 'H Line Skirt Front Pocket Corduroy Marigold',
            'price' => 269000,
            'image' => 'h-line-skirt-front-pocket-corduroy-marigold.png',
            'description' => 'Midi H-line skirt constructed in finely textured corduroy featuring deep front utility pockets.',
        ],
        'fine-knit-polo-neck' => [
            'name' => 'Fine Knit Polo Neck',
            'price' => 219000,
            'image' => 'fine-knit-polo-neck.png',
            'description' => 'Sophisticated fine gauge knit sweater with a sleek polo collar and ribbed trims.',
        ],
        'crew-neck' => [
            'name' => 'Crew Neck',
            'price' => 169000,
            'image' => 'crew-neck.png',
            'description' => 'Minimalist everyday crew-neck sweatshirt crafted from comfortable French terry.',
        ],
        'striped-shirt' => [
            'name' => 'Striped Shirt',
            'price' => 229000,
            'image' => 'striped-shirt.png',
            'description' => 'Crisp yarn-dyed vertical stripe button-down shirt designed with a relaxed casual silhouette.',
        ],
        'regular-tshirt' => [
            'name' => 'Regular T Shirt',
            'price' => 129000,
            'image' => 'regular-tshirt.png',
            'description' => 'Breathable everyday basic t-shirt made with 100% natural organic cotton fibers.',
        ],
        'dark-turquoise-nylon-windbreaker' => [
            'name' => 'Dark Turquoise Nylon Windbreaker',
            'price' => 349000,
            'image' => 'dark-turquoise-nylon-windbreaker.png',
            'description' => 'Lightweight and packable nylon windbreaker featuring a half-zip neckline and wind-resistant exterior.',
        ],
        'collared-jacket' => [
            'name' => 'Collared Jacket',
            'price' => 399000,
            'image' => 'collared-jacket.png',
            'description' => 'Classic zip-front collared jacket in matte faux leather with dual side hand-warmer pockets.',
        ],
        'pile-lined-fleece-blouson' => [
            'name' => 'Pile Lined Fleece Blouson',
            'price' => 359000,
            'image' => 'pile-lined-fleece-blouson.png',
            'description' => 'Plush high-pile fleece jacket with zip closure designed to retain warmth on chilly days.',
        ],
        'black-cardigan' => [
            'name' => 'Black Cardigan',
            'price' => 239000,
            'image' => 'black-cardigan.png',
            'description' => 'Fine knit button-up cardigan in deep black, ideal for versatile smart-casual styling.',
        ],
        'black-long-cat' => [
            'name' => 'Black Long Coat',
            'price' => 459000,
            'image' => 'black-long-cat.png',
            'description' => 'Elegant elongated silhouette overcoat offering structured tailoring and clean minimalist lines.',
        ],
        'long-jogger-pants-relaxed-fit-drawstring-frenzy' => [
            'name' => 'Long Jogger Pants Relaxed Fit Drawstring Frenzy',
            'price' => 259000,
            'image' => 'long-jogger-pants-relaxed-fit-drawstring-frenzy.png',
            'description' => 'Relaxed drawstring jogger pants finished with elastic cuffs and convenient side pockets.',
        ],
        'long-denim-pants-regular-fit-cotton-casey' => [
            'name' => 'Long Denim Pants Regular Fit Cotton Casey',
            'price' => 309000,
            'image' => 'long-denim-pants-regular-fit-cotton-casey.png',
            'description' => 'Mid-rise classic cotton denim jeans offering flexibility and everyday resilience.',
        ],
        'long-chino-pants-regular-fit-ferrero' => [
            'name' => 'Long Chino Pants Regular Fit Ferrero',
            'price' => 279000,
            'image' => 'long-chino-pants-regular-fit-ferrero.png',
            'description' => 'Clean-cut chino trousers made with stretch cotton twill for all-day comfort.',
        ],
        'midi-flare-skirt-babyterry-kasumi' => [
            'name' => 'Midi Flare Skirt Babyterry Kasumi',
            'price' => 219000,
            'image' => 'midi-flare-skirt-babyterry-kasumi.png',
            'description' => 'Soft baby-terry flared midi skirt featuring an elastic waistband and fluid drape.',
        ],
    ];

    public function show(string $productName): View|RedirectResponse
    {
        $slug = Str::slug($productName);

        // Find product or fallback to matching by key / slug / headline
        $product = $this->products[$slug] ?? null;

        if (!$product) {
            foreach ($this->products as $key => $data) {
                if ($key === $productName || Str::slug($data['name']) === $slug) {
                    $product = $data;
                    $slug = $key;
                    break;
                }
            }
        }

        // If still not found, construct a default product from the slug
        if (!$product) {
            $product = [
                'name' => Str::headline(str_replace('-', ' ', $productName)),
                'price' => 99999,
                'image' => 'basic-shirt-short-sleeve.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            ];
        }

        $recommendationSlugs = [
            'black-blazer',
            'cotton-peplum-top',
            'knit-cardigan-long-sleeve-sweater-loose-fit-candy',
            'long-denim-pants-regular-fit-jeans-cotton-arumi',
            't-shirt-short-sleeve-regular-fit-cotton-nanami',
            'bomber-jacket-regular-fit-polyester-reygan',
            'long-straight-denim-pants-loose-fit-jeans-cotton-cassie',
            'h-line-skirt-front-pocket-corduroy-marigold',
        ];

        $discoverProducts = [];
        foreach ($recommendationSlugs as $recSlug) {
            if (isset($this->products[$recSlug])) {
                $p = $this->products[$recSlug];
                $discoverProducts[] = [
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'image' => asset('images/' . $p['image']),
                    'secondImage' => asset('images/' . $p['image']),
                    'href' => route('product.show', ['productName' => $recSlug]),
                ];
            }
        }

        return view('product-detail', [
            'product' => [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => asset('images/' . $product['image']),
                'secondImage' => asset('images/' . ($product['secondImage'] ?? $product['image'])),
                'description' => $product['description'],
                'slug' => $slug,
            ],
            'discoverProducts' => $discoverProducts,
        ]);
    }
}

