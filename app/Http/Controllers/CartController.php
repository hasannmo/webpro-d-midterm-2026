<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     */
    public function index(): View
    {
        $userId = auth()->id();

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });

        $totalItems = $cartItems->sum('quantity');

        return view('cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
        ]);
    }

    /**
     * Add an item to the shopping cart.
     */
    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $userId = auth()->id();
        $productId = (int) $validated['product_id'];
        $quantity = (int) ($validated['quantity'] ?? 1);

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $totalCartCount = CartItem::where('user_id', $userId)->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to your cart!',
                'cartCount' => $totalCartCount,
                'cart_count' => $totalCartCount,
                'item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                ],
            ]);
        }

        return back()->with('success', 'Item added to your cart!');
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cartItem->update([
            'quantity' => (int) $validated['quantity'],
        ]);

        $userId = auth()->id();
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $totalCount = $cartItems->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'quantity' => $cartItem->quantity,
                'itemSubtotal' => $cartItem->subtotal,
                'itemSubtotalFormatted' => number_format($cartItem->subtotal, 0, ',', '.'),
                'subtotal' => $subtotal,
                'subtotalFormatted' => number_format($subtotal, 0, ',', '.'),
                'cartCount' => $totalCount,
            ]);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cartItem->delete();

        $userId = auth()->id();
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $totalCount = $cartItems->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'subtotal' => $subtotal,
                'subtotalFormatted' => number_format($subtotal, 0, ',', '.'),
                'cartCount' => $totalCount,
                'isEmpty' => $cartItems->isEmpty(),
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Checkout entire cart.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $userId = auth()->id();
        $user = auth()->user();

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $now = Carbon::now();
        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product) continue;

            for ($i = 0; $i < $item->quantity; $i++) {
                Order::create([
                    'order_number' => 'ORD-' . $now->format('Ymd') . '-' . strtoupper(Str::random(5)),
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'customer_email' => $user->email,
                    'status' => 'completed',
                ]);
            }
        }

        // Clear cart
        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('myorder')->with('success', 'Thank you! Your order has been placed.');
    }
}
