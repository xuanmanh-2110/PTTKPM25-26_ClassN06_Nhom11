<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;

class ProductRepository
{
    // Lấy danh sách sản phẩm (admin)
    public function getAll($search = null, $perPage = 10)
    {
        $query = Product::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        return $query->latest()->paginate($perPage);
    }

    // Tạo sản phẩm
    public function create(array $data)
    {
        return Product::create($data);
    }

    // Cập nhật sản phẩm
    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    // Xóa sản phẩm
    public function delete(Product $product)
    {
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        return $product->delete();
    }

    // Gợi ý sản phẩm (search ajax)
    public function suggest(string $q, $limit = 10)
    {
        return Product::where('name', 'like', '%' . $q . '%')
            ->limit($limit)
            ->get(['id', 'name']);
    }

    // Shop (dành cho khách hàng)
    public function shop($search = null, $price = null, $sort = null, $perPage = 20)
    {
        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($price) {
            if ($price == '1') $query->where('price', '<', 200000);
            if ($price == '2') $query->whereBetween('price', [200000, 500000]);
            if ($price == '3') $query->where('price', '>', 500000);
        }

        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    // Thống kê analytics sản phẩm
    public function analytics(Product $product)
    {
        $reviews = $product->reviews()->with('user')->latest()->paginate(10);
        $totalReviews = $product->reviews()->count();
        $averageRating = $product->reviews()->avg('rating');

        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $product->reviews()->where('rating', $i)->count();
        }

        $orderItems = OrderItem::where('product_id', $product->id)->with('order')->get();
        $totalOrders = $orderItems->count();
        $totalRevenue = $orderItems->sum(fn($item) => $item->quantity * $item->price);

        $uniqueCustomers = $orderItems->pluck('order.customer_id')->filter()->unique()->count();
        $repurchaseRate = $uniqueCustomers > 0
            ? (($totalOrders - $uniqueCustomers) / $uniqueCustomers) * 100
            : 0;

        $recentOrders = OrderItem::where('product_id', $product->id)
            ->where('created_at', '>=', now()->subMonths(6))
            ->count();
        $avgMonthlyOrders = $recentOrders / 6;

        $reviewRate = $totalOrders > 0 ? ($totalReviews / $totalOrders) * 100 : 0;

        return compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingDistribution',
            'totalOrders',
            'totalRevenue',
            'repurchaseRate',
            'avgMonthlyOrders',
            'reviewRate'
        );
    }
}