<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        // Kiểm tra quyền admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Không có quyền truy cập');
        }

        // Lấy dữ liệu thống kê
        $stats = [
            'total_products' => Product::count(),
            'total_customers' => Customer::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
        ];

        // Xử lý tìm kiếm sản phẩm
        $search = $request->get('search');
        $productsQuery = Product::query()->withSum('orderItems', 'quantity');
        if ($search) {
            $productsQuery->where('name', 'LIKE', "%{$search}%");
        }
        $products = $productsQuery->latest()->paginate(10)->appends($request->query());

        // Lấy dữ liệu customers
        $customers = Customer::with('user')->latest()->paginate(10);

        // Xử lý bộ lọc đơn hàng
        $ordersQuery = Order::with(['customer', 'items.product']);
        
        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== '') {
            $ordersQuery->where('status', $request->status);
        }
        
        // Lọc theo ngày
        if ($request->has('from_date') && $request->from_date) {
            $ordersQuery->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $ordersQuery->whereDate('created_at', '<=', $request->to_date);
        }
        
        $orders = $ordersQuery->orderBy('id', 'asc')->paginate(10)->appends($request->query());

        // Thống kê đơn hàng
        $orderStats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'delivered')
                                              ->sum('total_amount'),
            'average_order_value' => Order::where('status', 'delivered')
                                                     ->avg('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'this_month_orders' => Order::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
        ];

        // Nếu là AJAX request, chỉ trả về partial view
        if ($request->ajax()) {
            $html = view('admin.partials.orders-table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.dashboard', compact('stats', 'products', 'customers', 'orders', 'search', 'orderStats'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        // Kiểm tra quyền admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Không có quyền truy cập');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function destroyOrder(Order $order)
    {
        // Kiểm tra quyền admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Không có quyền truy cập');
        }

        $order->delete();

        return redirect()->back()->with('success', 'Xóa đơn hàng thành công!');
    }

    public function destroyProduct(Product $product)
    {
        // Kiểm tra quyền admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Không có quyền truy cập');
        }

        // Xóa ảnh nếu có
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }

        $product->delete();

        return redirect()->back()->with('success', 'Xóa sản phẩm thành công!');
    }
}