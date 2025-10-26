<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsForAdmin($search = null, $perPage = 10)
    {
        return $this->productRepository->getAll($search, $perPage);
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product)
    {
        return $this->productRepository->delete($product);
    }

    public function suggest($q, $limit = 10)
    {
        return $this->productRepository->suggest($q, $limit);
    }

    public function getShopProducts($search = null, $price = null, $sort = null, $perPage = 20)
    {
        return $this->productRepository->shop($search, $price, $sort, $perPage);
    }

    public function getProductAnalytics(Product $product)
    {
        return $this->productRepository->analytics($product);
    }
}