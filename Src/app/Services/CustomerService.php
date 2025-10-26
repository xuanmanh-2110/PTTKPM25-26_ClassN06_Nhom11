<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers($perPage = 10)
    {
        return $this->customerRepository->getAllWithUser($perPage);
    }

    public function createCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(Customer $customer, array $data)
    {
        return $this->customerRepository->update($customer, $data);
    }

    public function deleteCustomer(Customer $customer)
    {
        return $this->customerRepository->delete($customer);
    }

    public function getOrders(Customer $customer, $perPage = 10)
    {
        return $this->customerRepository->getOrders($customer, $perPage);
    }
}