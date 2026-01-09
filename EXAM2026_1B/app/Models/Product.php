<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;

    /**
     * Các trường có thể điền (mass assignment)
     */
    protected $fillable = [
        'store_id',
        'name',
        'description',
        'price',
        'created_at',

    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
