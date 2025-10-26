<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    /**
     * Lấy danh sách khách hàng kèm user liên kết, phân trang.
     */
    public function getAllWithUser($perPage = 10)
    {
        return Customer::with('user')->paginate($perPage);
    }

    /**
     * Tạo mới khách hàng.
     */
    public function create(array $data)
    {
        return Customer::create($data);
    }

    /**
     * Cập nhật thông tin khách hàng.
     */
    public function update(Customer $customer, array $data)
    {
        $customer->update($data);
        return $customer;
    }

    /**
     * Xóa khách hàng.
     */
    public function delete(Customer $customer)
    {
        return $customer->delete();
    }

    /**
     * Lấy danh sách đơn hàng của khách hàng, phân trang.
     */
    public function getOrders(Customer $customer, $perPage = 10)
    {
        return $customer->orders()->with('items.product')->paginate($perPage);
    }
}