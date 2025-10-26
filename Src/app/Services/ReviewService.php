<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\ReviewRepository;

class ReviewService
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getAllForProduct($productId, $perPage = 10)
    {
        return $this->reviewRepository->getAllForProduct($productId, $perPage);
    }

    public function createReview(array $data)
    {
        return $this->reviewRepository->create($data);
    }

    public function updateReview(Review $review, array $data)
    {
        return $this->reviewRepository->update($review, $data);
    }

    public function deleteReview(Review $review)
    {
        return $this->reviewRepository->delete($review);
    }

    public function getAverageRating($productId)
    {
        return $this->reviewRepository->getAverageRating($productId);
    }

    public function getRatingDistribution($productId)
    {
        return $this->reviewRepository->getRatingDistribution($productId);
    }
}