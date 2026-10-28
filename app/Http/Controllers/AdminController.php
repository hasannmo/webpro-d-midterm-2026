<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected function getChartForRange(string $range): array
    {
        return match ($range) {
            '1m' => [
                'data' => [120, 145, 132, 168],
                'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            ],
            '3m' => [
                'data' => [380, 420, 510],
                'labels' => ['Month 1', 'Month 2', 'Month 3'],
            ],
            '6m' => [
                'data' => [290, 340, 410, 390, 480, 540],
                'labels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            ],
            '1y' => [
                'data' => [820, 940, 1120, 1340],
                'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
            ],
            default => [
                'data' => [12, 19, 15, 27, 22, 34, 30],
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            ],
        };
    }

    public function dashboard(Request $request): View
    {
        $selected = $request->query('range', '7d');
        $chart = $this->getChartForRange($selected);

        return view('admin.dashboard', [
            'active' => 'dashboard',
            'selected' => $selected,
            'totalOrder' => 1254,
            'totalUser' => 842,
            'chartData' => $chart['data'],
            'chartLabels' => $chart['labels'],
        ]);
    }

    public function order(Request $request): View
    {
        $selected = $request->query('range', '7d');
        $chart = $this->getChartForRange($selected);

        $allOrders = [
            ['id' => 'ORD-20261028-001', 'product' => 'Basic Shirt Short Sleeve', 'price' => 99999, 'email' => 'sarah.smith@example.com', 'date' => Carbon::now()->subMinutes(14)],
            ['id' => 'ORD-20261028-002', 'product' => 'Black Blazer', 'price' => 299000, 'email' => 'david.miller@example.com', 'date' => Carbon::now()->subHours(1)],
            ['id' => 'ORD-20261028-003', 'product' => 'Cotton Peplum Top', 'price' => 199000, 'email' => 'emily.chen@example.com', 'date' => Carbon::now()->subHours(3)],
            ['id' => 'ORD-20261028-004', 'product' => 'Knit Cardigan Long Sleeve', 'price' => 249000, 'email' => 'budi.santoso@example.com', 'date' => Carbon::now()->subHours(5)],
            ['id' => 'ORD-20261028-005', 'product' => 'Long Denim Pants Regular Fit', 'price' => 319000, 'email' => 'siti.nurhaliza@example.com', 'date' => Carbon::now()->subHours(9)],
            ['id' => 'ORD-20261028-006', 'product' => 'Bomber Jacket Reygan', 'price' => 379000, 'email' => 'alex.rossi@example.com', 'date' => Carbon::now()->subDay()],
            ['id' => 'ORD-20261028-007', 'product' => 'Fine Knit Polo Neck', 'price' => 219000, 'email' => 'rachel.adams@example.com', 'date' => Carbon::now()->subDays(2)],
            ['id' => 'ORD-20261028-008', 'product' => 'Striped Shirt', 'price' => 229000, 'email' => 'michael.tan@example.com', 'date' => Carbon::now()->subDays(2)],
            ['id' => 'ORD-20261028-009', 'product' => 'Collared Jacket', 'price' => 399000, 'email' => 'lisa.wong@example.com', 'date' => Carbon::now()->subDays(3)],
            ['id' => 'ORD-20261028-010', 'product' => 'Dark Turquoise Windbreaker', 'price' => 349000, 'email' => 'kevin.pratama@example.com', 'date' => Carbon::now()->subDays(4)],
        ];

        $page = (int) $request->query('page', 1);
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        $sliced = array_slice($allOrders, $offset, $perPage);

        $paginator = new LengthAwarePaginator(
            $sliced,
            count($allOrders),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.order', [
            'active' => 'order',
            'selected' => $selected,
            'total' => count($allOrders),
            'orders' => $paginator->items(),
            'paginator' => $paginator,
            'chartData' => $chart['data'],
            'chartLabels' => $chart['labels'],
        ]);
    }

    public function product(): View
    {
        $products = [
            ['name' => 'Basic Shirt Short Sleeve', 'price' => 99999, 'image' => asset('images/basic-shirt-short-sleeve.png'), 'editHref' => '#', 'removeAction' => '#'],
            ['name' => 'Black Blazer', 'price' => 299000, 'image' => asset('images/black-blazer.png'), 'editHref' => '#', 'removeAction' => '#'],
            ['name' => 'Cotton Peplum Top', 'price' => 199000, 'image' => asset('images/cotton-peplum-top.png'), 'editHref' => '#', 'removeAction' => '#'],
            ['name' => 'Knit Cardigan Candy', 'price' => 249000, 'image' => asset('images/knit-cardigan-long-sleeve-sweater-loose-fit-candy.png'), 'editHref' => '#', 'removeAction' => '#'],
            ['name' => 'Long Denim Pants Arumi', 'price' => 319000, 'image' => asset('images/long-denim-pants-regular-fit-jeans-cotton-arumi.png'), 'editHref' => '#', 'removeAction' => '#'],
            ['name' => 'Bomber Jacket Reygan', 'price' => 379000, 'image' => asset('images/bomber-jacket-regular-fit-polyester-reygan.png'), 'editHref' => '#', 'removeAction' => '#'],
        ];

        return view('admin.product', [
            'active' => 'product',
            'products' => $products,
        ]);
    }

    public function account(Request $request): View
    {
        $allUsers = [
            ['username' => 'sarahsmith', 'email' => 'sarah.smith@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subDays(2), 'manageHref' => '#'],
            ['username' => 'davidmiller', 'email' => 'david.miller@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subDays(5), 'manageHref' => '#'],
            ['username' => 'emilychen', 'email' => 'emily.chen@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subDays(10), 'manageHref' => '#'],
            ['username' => 'budisantoso', 'email' => 'budi.santoso@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subDays(12), 'manageHref' => '#'],
            ['username' => 'admin_mijusan', 'email' => 'admin@mijusan.com', 'role' => 'Administrator', 'date' => Carbon::now()->subMonths(3), 'manageHref' => '#'],
            ['username' => 'alexrossi', 'email' => 'alex.rossi@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subMonths(1), 'manageHref' => '#'],
            ['username' => 'racheladams', 'email' => 'rachel.adams@example.com', 'role' => 'Customer', 'date' => Carbon::now()->subMonths(2), 'manageHref' => '#'],
        ];

        $page = (int) $request->query('page', 1);
        $perPage = 4;
        $offset = ($page - 1) * $perPage;
        $sliced = array_slice($allUsers, $offset, $perPage);

        $paginator = new LengthAwarePaginator(
            $sliced,
            count($allUsers),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.account', [
            'active' => 'account',
            'users' => $paginator->items(),
            'total' => count($allUsers),
            'paginator' => $paginator,
        ]);
    }
}

