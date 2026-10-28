<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    protected function resolveProduct(string $productName): Product
    {
        $slug = Str::slug($productName);

        $product = Product::where('slug', $slug)
            ->orWhere('id', $productName)
            ->orWhere('slug', $productName)
            ->first();

        if (!$product) {
            $product = Product::firstOrFail();
        }

        return $product;
    }

    public function show(string $productName): View
    {
        $product = $this->resolveProduct($productName);
        $confirmed = session('checkout_confirmed_' . $product->slug, false);

        return view('checkout', [
            'product' => [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'slug' => $product->slug,
            ],
            'confirmed' => $confirmed,
            'confirmAction' => route('checkout.confirm', ['productName' => $product->slug]),
            'cancelHref' => route('product.show', ['productName' => $product->slug]),
        ]);
    }

    public function confirm(string $productName): RedirectResponse
    {
        $product = $this->resolveProduct($productName);

        // Record order to database
        Order::create([
            'order_number' => 'ORD-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'user_id' => auth()->id() ?? null,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'customer_email' => auth()->user()->email ?? 'customer@example.com',
            'status' => 'completed',
        ]);

        session()->flash('checkout_confirmed_' . $product->slug, true);

        return redirect()->route('checkout.show', ['productName' => $product->slug])
            ->with('status', 'Your checkout has been confirmed!');
    }
}
