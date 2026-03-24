<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'stock',
        'photo',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where('name', 'LIKE', "%{$term}%");
        }
    }

    public function toSearchableArray()
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'brand'=> $this->brand,
        ];
    }
    
}
