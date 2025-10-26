<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Repositories\OrderItemRepository;

class OrderItemService
{
    protected $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getAllByOrder($orderId)
    {
        return $this->orderItemRepository->getAllByOrder($orderId);
    }

    public function createOrderItem(array $data)
    {
        return $this->orderItemRepository->create($data);
    }

    public function updateOrderItem(OrderItem $orderItem, array $data)
    {
        return $this->orderItemRepository->update($orderItem, $data);
    }

    public function deleteOrderItem(OrderItem $orderItem)
    {
        return $this->orderItemRepository->delete($orderItem);
    }
}