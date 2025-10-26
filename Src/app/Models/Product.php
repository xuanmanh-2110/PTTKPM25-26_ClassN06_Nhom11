<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = ['name', 'description', 'price', 'image', 'stock', 'category'];
   
   protected $dates = ['created_at', 'updated_at'];
   
   // Phương thức để hiển thị thời gian đầy đủ theo múi giờ Việt Nam
   public function getFormattedCreatedAtAttribute()
   {
       return $this->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
   }

   /**
    * Get the reviews for the product.
    */
   public function reviews()
   {
       return $this->hasMany(Review::class);
   }

   /**
    * Get the average rating for the product.
    */
   public function averageRating()
   {
       return $this->reviews()->avg('rating');
   }

   /**
    * Quan hệ với OrderItem để thống kê bán hàng
    */
   public function orderItems()
   {
       return $this->hasMany(\App\Models\OrderItem::class);
   }

   /**
    * Get the total number of reviews for the product.
    */
   public function reviewsCount()
   {
       return $this->reviews()->count();
   }
}

