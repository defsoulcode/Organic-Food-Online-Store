<?php

namespace App\Models;

use App\Models\Distribut;
use App\Models\Category;
use App\Models\ReviewRating;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['category', 'distribut', 'ReviewData'];

    public function distribut()
    {
        return $this->belongsTo(Distribut::class, 'distribut_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ReviewData()
    {
        return $this->hasMany(ReviewRating::class, 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->hasMany(cart::class, 'product_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name_prod', 'like', '%' . $search . '%')
                ->orWhere('code_prod', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['distribut'] ?? false, function($query, $distribut) {
            return $query->whereHas('distribut', function($query) use ($distribut) {
                $query->where('slug', $distribut);
            });
        });
    }
}