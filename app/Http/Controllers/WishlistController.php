<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        // Get actual wishlisted products for this logged-in user
        $wishlistProducts = Product::whereHas('wishlists', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        $wishlistItems = $wishlistProducts->map(function ($product) {
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

    public function toggle(Request $request, int $productId): JsonResponse|RedirectResponse
    {
        $userId = auth()->id();
        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $status = 'added';
        }

        if ($request->wantsJson()) {
            return response()->json(['status' => $status]);
        }

        return back();
    }
}

