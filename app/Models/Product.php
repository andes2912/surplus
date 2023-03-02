<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table    = 'products';
    protected $guarded  = [];

    public function rawPayload($request)
    {
        $payload['name']        = $request->name ?? null;
        $payload['description'] = $request->description ?? null;
        $payload['enable']      = $request->enable ?? null;
        return $payload;
    }
}
