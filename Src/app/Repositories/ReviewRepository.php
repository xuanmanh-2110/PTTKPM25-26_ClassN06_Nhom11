<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    public function getAllForProduct($productId, $perPage = 10)
    {
        return Review::forProduct($productId)->newest()->with('user')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data)
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review)
    {
        return $review->delete();
    }

    public function getAverageRating($productId)
    {
        return Review::forProduct($productId)->avg('rating');
    }

    public function getRatingDistribution($productId)
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = Review::forProduct($productId)->where('rating', $i)->count();
        }
        return $distribution;
    }
}