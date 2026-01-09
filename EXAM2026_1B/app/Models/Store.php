<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Model
{
    //
    use HasFactory;

    /**
     * Các trường có thể điền (mass assignment)
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];


    /**
     * Quan hệ: Một Srotes có nhiều Product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
