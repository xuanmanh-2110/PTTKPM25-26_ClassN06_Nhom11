<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function getAllByOrder($orderId)
    {
        return OrderItem::where('order_id', $orderId)->with('product')->get();
    }

    public function create(array $data)
    {
        return OrderItem::create($data);
    }

    public function update(OrderItem $orderItem, array $data)
    {
        $orderItem->update($data);
        return $orderItem;
    }

    public function delete(OrderItem $orderItem)
    {
        return $orderItem->delete();
    }
}