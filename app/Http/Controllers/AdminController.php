<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected function getChartForRange(string $range): array
    {
        $now = Carbon::now();

        switch ($range) {
            case '1m':
                $startDate = $now->copy()->subDays(28)->startOfDay();
                $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                $data = [0, 0, 0, 0];
                $orders = Order::where('created_at', '>=', $startDate)->get();
                foreach ($orders as $order) {
                    $daysAgo = abs($now->diffInDays($order->created_at));
                    $weekIdx = 3 - min(3, max(0, (int) floor($daysAgo / 7)));
                    $data[$weekIdx]++;
                }
                break;

            case '3m':
                $startDate = $now->copy()->subMonths(3)->startOfDay();
                $labels = [
                    $now->copy()->subMonths(2)->format('M'),
                    $now->copy()->subMonth()->format('M'),
                    $now->format('M'),
                ];
                $data = [0, 0, 0];
                $orders = Order::where('created_at', '>=', $startDate)->get();
                foreach ($orders as $order) {
                    $monthDiff = abs($now->diffInMonths($order->created_at));
                    $mIdx = 2 - min(2, max(0, $monthDiff));
                    $data[$mIdx]++;
                }
                break;

            case '6m':
                $startDate = $now->copy()->subMonths(6)->startOfDay();
                $labels = [];
                for ($i = 5; $i >= 0; $i--) {
                    $labels[] = $now->copy()->subMonths($i)->format('M');
                }
                $data = array_fill(0, 6, 0);
                $orders = Order::where('created_at', '>=', $startDate)->get();
                foreach ($orders as $order) {
                    $mDiff = abs($now->diffInMonths($order->created_at));
                    $idx = 5 - min(5, max(0, $mDiff));
                    $data[$idx]++;
                }
                break;

            case '1y':
                $startDate = $now->copy()->subYear()->startOfDay();
                $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
                $data = [0, 0, 0, 0];
                $orders = Order::where('created_at', '>=', $startDate)->get();
                foreach ($orders as $order) {
                    $mDiff = abs($now->diffInMonths($order->created_at));
                    $qIdx = 3 - min(3, max(0, (int) floor($mDiff / 3)));
                    $data[$qIdx]++;
                }
                break;

            case '7d':
            default:
                $startDate = $now->copy()->subDays(6)->startOfDay();
                $labels = [];
                for ($i = 6; $i >= 0; $i--) {
                    $labels[] = $now->copy()->subDays($i)->format('D');
                }
                $data = array_fill(0, 7, 0);
                $orders = Order::where('created_at', '>=', $startDate)->get();
                foreach ($orders as $order) {
                    $dayDiff = abs($now->diffInDays($order->created_at));
                    $idx = 6 - min(6, max(0, (int) $dayDiff));
                    $data[$idx]++;
                }
                break;
        }

        return ['data' => $data, 'labels' => $labels];
    }

    public function dashboard(Request $request): View
    {
        $selected = $request->query('range', '7d');
        $chart = $this->getChartForRange($selected);

        return view('admin.dashboard', [
            'active' => 'dashboard',
            'selected' => $selected,
            'totalOrder' => Order::count(),
            'totalUser' => User::count(),
            'chartData' => $chart['data'],
            'chartLabels' => $chart['labels'],
        ]);
    }

    public function order(Request $request): View
    {
        $selected = $request->query('range', '7d');
        $chart = $this->getChartForRange($selected);

        $paginator = Order::latest()->paginate(5)->withQueryString();

        $orders = collect($paginator->items())->map(function ($order) {
            return [
                'id' => $order->order_number,
                'product' => $order->product_name,
                'price' => $order->price,
                'email' => $order->customer_email,
                'date' => $order->created_at,
            ];
        })->all();

        return view('admin.order', [
            'active' => 'order',
            'selected' => $selected,
            'total' => Order::count(),
            'orders' => $orders,
            'paginator' => $paginator,
            'chartData' => $chart['data'],
            'chartLabels' => $chart['labels'],
        ]);
    }

    public function product(): View
    {
        $products = Product::latest()->get()->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'editHref' => route('admin.product.edit', ['productName' => $product->slug]),
                'removeAction' => route('admin.product.destroy', ['productName' => $product->slug]),
            ];
        })->all();

        return view('admin.product', [
            'active' => 'product',
            'products' => $products,
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.add-product', [
            'active' => 'product',
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:top,outer,bottom',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
            'image_name' => 'nullable|string',
        ]);

        $imagePath = 'basic-shirt-short-sleeve.png';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $imagePath = $fileName;
        } elseif (!empty($request->image_name)) {
            $imagePath = $request->image_name;
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => (int) $validated['price'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? '',
            'image' => $imagePath,
            'second_image' => $imagePath,
        ]);

        return redirect()->route('admin.product')->with('success', 'Product created successfully.');
    }

    public function editProduct(string $productName): View
    {
        $product = Product::where('slug', $productName)->orWhere('id', $productName)->firstOrFail();

        return view('admin.edit-product', [
            'active' => 'product',
            'product' => $product,
        ]);
    }

    public function updateProduct(Request $request, string $productName): RedirectResponse
    {
        $product = Product::where('slug', $productName)->orWhere('id', $productName)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:top,outer,bottom',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
            'image_name' => 'nullable|string',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $imagePath = $fileName;
        } elseif (!empty($request->image_name)) {
            $imagePath = $request->image_name;
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => (int) $validated['price'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? '',
            'image' => $imagePath,
            'second_image' => $imagePath,
        ]);

        return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
    }

    public function destroyProduct(string $productName): RedirectResponse
    {
        $product = Product::where('slug', $productName)->orWhere('id', $productName)->firstOrFail();
        $product->delete();

        return redirect()->route('admin.product')->with('success', 'Product removed successfully.');
    }

    public function account(Request $request): View
    {
        $paginator = User::latest()->paginate(5)->withQueryString();

        $users = collect($paginator->items())->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'username' => $u->username ?? Str::slug($u->name),
                'email' => $u->email,
                'role' => $u->role ?? 'Customer',
                'isCreator' => $u->isCreator(),
                'date' => $u->created_at,
            ];
        })->all();

        return view('admin.account', [
            'active' => 'account',
            'users' => $users,
            'total' => User::count(),
            'paginator' => $paginator,
        ]);
    }

    public function createUser(): View
    {
        return view('admin.add-user', [
            'active' => 'account',
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $roleRules = auth()->user()->isCreator() ? 'in:Customer,Administrator,Creator' : 'in:Customer,Administrator';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|' . $roleRules,
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'] ?? Str::slug($validated['name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.account')->with('success', 'User created successfully.');
    }

    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $targetUser = User::findOrFail($id);
        $currentUser = auth()->user();

        // If target is Creator, only a Creator can edit it (cannot edit self into lower role if desired, or can edit other creators)
        if ($targetUser->isCreator() && !$currentUser->isCreator()) {
            return redirect()->route('admin.account')->with('error', 'Only a Creator can modify another Creator.');
        }

        $allowedRoles = $currentUser->isCreator()
            ? 'in:Customer,Administrator,Creator'
            : 'in:Customer,Administrator';

        $validated = $request->validate([
            'role' => 'required|string|' . $allowedRoles,
        ]);

        $targetUser->update(['role' => $validated['role']]);

        return redirect()->route('admin.account')->with('success', "Updated {$targetUser->name}'s role to {$validated['role']}.");
    }

    public function destroyUser(int $id): RedirectResponse
    {
        $targetUser = User::findOrFail($id);
        $currentUser = auth()->user();

        if ($targetUser->id === $currentUser->id) {
            return redirect()->route('admin.account')->with('error', 'You cannot remove your own account.');
        }

        if ($targetUser->isCreator() && !$currentUser->isCreator()) {
            return redirect()->route('admin.account')->with('error', 'Only a Creator can remove another Creator account.');
        }

        $targetUser->delete();

        return redirect()->route('admin.account')->with('success', "User {$targetUser->email} has been removed.");
    }
}
