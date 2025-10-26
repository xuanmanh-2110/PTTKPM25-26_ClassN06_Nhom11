<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderRepository
{
    /**
     * Tạo đơn hàng mới
     */
    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Thêm các sản phẩm vào đơn hàng
     */
    public function addOrderItems(Order $order, array $cart): Order
    {
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $qty = $item['quantity'];
            $price = $item['price'];

            $total += $price * $qty;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $qty,
                'price'      => $price,
            ]);
        }

        $order->update(['total_amount' => $total]);
        return $order;
    }

    /**
     * Tìm đơn hàng theo ID
     */
    public function find($id): ?Order
    {
        return Order::find($id);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Order $order, string $status, ?string $transactionId = null): Order
    {
        $order->update([
            'status' => $status,
            'transaction_id' => $transactionId,
        ]);
        return $order;
    }
}