<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Repositories\CustomerRepository;

class CheckoutService
{
    protected $orderRepository;
    protected $customerRepository;

    public function __construct(OrderRepository $orderRepository, CustomerRepository $customerRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
    }

    public function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function createOrder($cart, $request)
    {
        $user = Auth::user();

        // Tìm hoặc tạo Customer
        $customer = $this->customerRepository->findOrCreateByEmail(
            $user->email,
            ['name' => $user->name, 'phone' => $request->phone]
        );

        $this->customerRepository->update($customer, [
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Tạo order
        $orderData = [
            'customer_id' => $customer->id,
            'total_amount' => 0,
            'payment_method' => $request->payment_method,
        ];

        if ($request->payment_method === 'bank_transfer') {
            $orderData['customer_bank_name'] = $request->customer_bank_name;
            $orderData['customer_account_number'] = $request->customer_account_number;
        }

        $order = $this->orderRepository->createOrder($orderData);

        $order = $this->orderRepository->addOrderItems($order, $cart);

        return $order;
    }
}