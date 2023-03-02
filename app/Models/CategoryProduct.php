<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rawPayload($request)
    {
        $payload['category_id'] = $request->category_id;
        $payload['product_id']  = $request->product_id;
        return $payload;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
       return $this->belongsTo(Product::class);
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where('name', 'LIKE', '%'.$keyword.'%');
        return $query;
    }
}
