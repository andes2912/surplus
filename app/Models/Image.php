<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rawPayload($request)
    {
        $payload['name']    = $request->name;
        $payload['file']    = $request->file;
        $payload['enable']  = $request->enable;
        return $payload;
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where('name', 'LIKE', '%'.$keyword.'%');
        return $query;
    }
}
