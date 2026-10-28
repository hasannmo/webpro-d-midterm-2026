<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class MyOrderController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email ?? '';

        $orders = Order::where(function ($query) use ($userId, $userEmail) {
            $query->where('user_id', $userId)
                ->orWhere('customer_email', $userEmail);
        })
        ->with('product')
        ->latest()
        ->paginate(8);

        return view('myorder', [
            'orders' => $orders,
        ]);
    }
}

