<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function rawPayload($request)
    {
        $payload['name']    = $request->name ?? null;
        $payload['enable']  = $request->enable ?? null;
        return $payload;
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where('name', 'LIKE', '%'.$keyword.'%');
        return $query;
    }
}
