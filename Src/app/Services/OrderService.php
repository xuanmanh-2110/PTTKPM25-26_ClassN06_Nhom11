<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $data)
    {
        return $this->orderRepository->createOrder($data);
    }

    public function addOrderItems(Order $order, array $cart)
    {
        return $this->orderRepository->addOrderItems($order, $cart);
    }

    public function findOrder($id)
    {
        return $this->orderRepository->find($id);
    }

    public function updateStatus(Order $order, string $status, ?string $transactionId = null)
    {
        return $this->orderRepository->updateStatus($order, $status, $transactionId);
    }
}