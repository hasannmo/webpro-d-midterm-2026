<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Products
        $initialProducts = [
            [
                'name' => 'Basic Shirt Short Sleeve',
                'slug' => 'basic-shirt-short-sleeve',
                'price' => 99999,
                'category' => 'top',
                'image' => 'basic-shirt-short-sleeve.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            ],
            [
                'name' => 'Black Blazer',
                'slug' => 'black-blazer',
                'price' => 299000,
                'category' => 'outer',
                'image' => 'black-blazer.png',
                'description' => 'Timeless and versatile tailoring crafted from structured fabric. Designed with a clean silhouette that effortlessly transitions from formal meetings to evening leisure.',
            ],
            [
                'name' => 'Cotton Peplum Top',
                'slug' => 'cotton-peplum-top',
                'price' => 199000,
                'category' => 'top',
                'image' => 'cotton-peplum-top.png',
                'description' => 'A feminine sleeveless top cut from soft cotton poplin with a flattering flared peplum waistline.',
            ],
            [
                'name' => 'Knit Cardigan Long Sleeve Sweater Loose Fit Candy',
                'slug' => 'knit-cardigan-long-sleeve-sweater-loose-fit-candy',
                'price' => 249000,
                'category' => 'outer',
                'image' => 'knit-cardigan-long-sleeve-sweater-loose-fit-candy.png',
                'description' => 'Charming crochet-knit loose fit cardigan, soft to the touch and perfect for breezy everyday layering.',
            ],
            [
                'name' => 'Long Denim Pants Regular Fit Jeans Cotton Arumi',
                'slug' => 'long-denim-pants-regular-fit-jeans-cotton-arumi',
                'price' => 319000,
                'category' => 'bottom',
                'image' => 'long-denim-pants-regular-fit-jeans-cotton-arumi.png',
                'description' => 'Classic five-pocket regular fit denim jeans tailored from durable pure cotton denim wash.',
            ],
            [
                'name' => 'T Shirt Short Sleeve Regular Fit Cotton Nanami',
                'slug' => 't-shirt-short-sleeve-regular-fit-cotton-nanami',
                'price' => 149000,
                'category' => 'top',
                'image' => 't-shirt-short-sleeve-regular-fit-cotton-nanami.png',
                'description' => 'An essential regular-fit crew neck tee spun from premium heavyweight combed cotton.',
            ],
            [
                'name' => 'Bomber Jacket Regular Fit Polyester Reygan',
                'slug' => 'bomber-jacket-regular-fit-polyester-reygan',
                'price' => 379000,
                'category' => 'outer',
                'image' => 'bomber-jacket-regular-fit-polyester-reygan.png',
                'description' => 'Sporty everyday bomber jacket with a clean ribbed collar, smooth zip closure, and water-repellent finish.',
            ],
            [
                'name' => 'Long Straight Denim Pants Loose Fit Jeans Cotton Cassie',
                'slug' => 'long-straight-denim-pants-loose-fit-jeans-cotton-cassie',
                'price' => 329000,
                'category' => 'bottom',
                'image' => 'long-straight-denim-pants-loose-fit-jeans-cotton-cassie.png',
                'description' => 'Relaxed loose-fit straight jeans with contrast turnover hems for an effortless streetwear edge.',
            ],
            [
                'name' => 'H Line Skirt Front Pocket Corduroy Marigold',
                'slug' => 'h-line-skirt-front-pocket-corduroy-marigold',
                'price' => 269000,
                'category' => 'bottom',
                'image' => 'h-line-skirt-front-pocket-corduroy-marigold.png',
                'description' => 'Midi H-line skirt constructed in finely textured corduroy featuring deep front utility pockets.',
            ],
            [
                'name' => 'Fine Knit Polo Neck',
                'slug' => 'fine-knit-polo-neck',
                'price' => 219000,
                'category' => 'top',
                'image' => 'fine-knit-polo-neck.png',
                'description' => 'Sophisticated fine gauge knit sweater with a sleek polo collar and ribbed trims.',
            ],
            [
                'name' => 'Crew Neck',
                'slug' => 'crew-neck',
                'price' => 169000,
                'category' => 'top',
                'image' => 'crew-neck.png',
                'description' => 'Minimalist everyday crew-neck sweatshirt crafted from comfortable French terry.',
            ],
            [
                'name' => 'Striped Shirt',
                'slug' => 'striped-shirt',
                'price' => 229000,
                'category' => 'top',
                'image' => 'striped-shirt.png',
                'description' => 'Crisp yarn-dyed vertical stripe button-down shirt designed with a relaxed casual silhouette.',
            ],
            [
                'name' => 'Regular T Shirt',
                'slug' => 'regular-tshirt',
                'price' => 129000,
                'category' => 'top',
                'image' => 'regular-tshirt.png',
                'description' => 'Breathable everyday basic t-shirt made with 100% natural organic cotton fibers.',
            ],
            [
                'name' => 'Dark Turquoise Nylon Windbreaker',
                'slug' => 'dark-turquoise-nylon-windbreaker',
                'price' => 349000,
                'category' => 'outer',
                'image' => 'dark-turquoise-nylon-windbreaker.png',
                'description' => 'Lightweight and packable nylon windbreaker featuring a half-zip neckline and wind-resistant exterior.',
            ],
            [
                'name' => 'Collared Jacket',
                'slug' => 'collared-jacket',
                'price' => 399000,
                'category' => 'outer',
                'image' => 'collared-jacket.png',
                'description' => 'Classic zip-front collared jacket in matte faux leather with dual side hand-warmer pockets.',
            ],
            [
                'name' => 'Pile Lined Fleece Blouson',
                'slug' => 'pile-lined-fleece-blouson',
                'price' => 359000,
                'category' => 'outer',
                'image' => 'pile-lined-fleece-blouson.png',
                'description' => 'Plush high-pile fleece jacket with zip closure designed to retain warmth on chilly days.',
            ],
            [
                'name' => 'Black Cardigan',
                'slug' => 'black-cardigan',
                'price' => 239000,
                'category' => 'outer',
                'image' => 'black-cardigan.png',
                'description' => 'Fine knit button-up cardigan in deep black, ideal for versatile smart-casual styling.',
            ],
            [
                'name' => 'Black Long Coat',
                'slug' => 'black-long-cat',
                'price' => 459000,
                'category' => 'outer',
                'image' => 'black-long-cat.png',
                'description' => 'Elegant elongated silhouette overcoat offering structured tailoring and clean minimalist lines.',
            ],
            [
                'name' => 'Long Jogger Pants Relaxed Fit Drawstring Frenzy',
                'slug' => 'long-jogger-pants-relaxed-fit-drawstring-frenzy',
                'price' => 259000,
                'category' => 'bottom',
                'image' => 'long-jogger-pants-relaxed-fit-drawstring-frenzy.png',
                'description' => 'Relaxed drawstring jogger pants finished with elastic cuffs and convenient side pockets.',
            ],
            [
                'name' => 'Long Denim Pants Regular Fit Cotton Casey',
                'slug' => 'long-denim-pants-regular-fit-cotton-casey',
                'price' => 309000,
                'category' => 'bottom',
                'image' => 'long-denim-pants-regular-fit-cotton-casey.png',
                'description' => 'Mid-rise classic cotton denim jeans offering flexibility and everyday resilience.',
            ],
            [
                'name' => 'Long Chino Pants Regular Fit Ferrero',
                'slug' => 'long-chino-pants-regular-fit-ferrero',
                'price' => 279000,
                'category' => 'bottom',
                'image' => 'long-chino-pants-regular-fit-ferrero.png',
                'description' => 'Clean-cut chino trousers made with stretch cotton twill for all-day comfort.',
            ],
            [
                'name' => 'Midi Flare Skirt Babyterry Kasumi',
                'slug' => 'midi-flare-skirt-babyterry-kasumi',
                'price' => 219000,
                'category' => 'bottom',
                'image' => 'midi-flare-skirt-babyterry-kasumi.png',
                'description' => 'Soft baby-terry flared midi skirt featuring an elastic waistband and fluid drape.',
            ],
        ];

        foreach ($initialProducts as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }

        // 2. Seed Users across the past 1 year
        $creatorUser = User::updateOrCreate(
            ['email' => 'creator@mijusan.com'],
            [
                'name' => 'Mijusan',
                'username' => 'mijusan_creator',
                'password' => Hash::make('Mijusan2910@)'),
                'role' => 'Creator',
                'created_at' => Carbon::now()->subMonths(12),
            ]
        );

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@mijusan.com'],
            [
                'name' => 'Admin Mijusan',
                'username' => 'admin_mijusan',
                'password' => Hash::make('password'),
                'role' => 'Administrator',
                'created_at' => Carbon::now()->subMonths(12),
            ]
        );

        $demoUsers = [
            ['name' => 'Sarah Smith', 'username' => 'sarahsmith', 'email' => 'sarah.smith@example.com', 'role' => 'Customer', 'months_ago' => 11],
            ['name' => 'David Miller', 'username' => 'davidmiller', 'email' => 'david.miller@example.com', 'role' => 'Customer', 'months_ago' => 9],
            ['name' => 'Emily Chen', 'username' => 'emilychen', 'email' => 'emily.chen@example.com', 'role' => 'Customer', 'months_ago' => 8],
            ['name' => 'Budi Santoso', 'username' => 'budisantoso', 'email' => 'budi.santoso@example.com', 'role' => 'Customer', 'months_ago' => 6],
            ['name' => 'Alex Rossi', 'username' => 'alexrossi', 'email' => 'alex.rossi@example.com', 'role' => 'Customer', 'months_ago' => 5],
            ['name' => 'Rachel Adams', 'username' => 'racheladams', 'email' => 'rachel.adams@example.com', 'role' => 'Customer', 'months_ago' => 3],
            ['name' => 'Michael Tan', 'username' => 'michaeltan', 'email' => 'michael.tan@example.com', 'role' => 'Customer', 'months_ago' => 2],
            ['name' => 'Siti Nurhaliza', 'username' => 'sitinur', 'email' => 'siti.nurhaliza@example.com', 'role' => 'Customer', 'months_ago' => 1],
            ['name' => 'Kevin Pratama', 'username' => 'kevinpratama', 'email' => 'kevin.pratama@example.com', 'role' => 'Customer', 'months_ago' => 0],
        ];

        $createdUsers = [$creatorUser, $adminUser];
        foreach ($demoUsers as $du) {
            $createdUsers[] = User::updateOrCreate(
                ['email' => $du['email']],
                [
                    'name' => $du['name'],
                    'username' => $du['username'],
                    'password' => Hash::make('password'),
                    'role' => $du['role'],
                    'created_at' => Carbon::now()->subMonths($du['months_ago'])->subDays(rand(1, 20)),
                ]
            );
        }

        // 3. Seed Orders spread across the last 1 year (365 days)
        $allProducts = Product::all();
        if ($allProducts->isEmpty()) return;

        // Clear previous orders to reseed cleanly
        Order::truncate();

        $startDate = Carbon::now()->subYear();
        $now = Carbon::now();

        // Generate ~140 distributed orders over the past 365 days
        $orderCounter = 1;
        for ($date = $startDate->copy(); $date->lte($now); $date->addDays(rand(1, 4))) {
            $user = $createdUsers[array_rand($createdUsers)];
            $product = $allProducts->random();
            $orderDate = $date->copy()->setTime(rand(8, 22), rand(0, 59), rand(0, 59));

            Order::create([
                'order_number' => 'ORD-' . $orderDate->format('Ymd') . '-' . str_pad($orderCounter++, 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'customer_email' => $user->email,
                'status' => 'completed',
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);
        }
    }
}
