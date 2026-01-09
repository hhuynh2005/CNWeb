<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class School extends Model
{
    //  use HasFactory;

    /**
     * Các trường có thể điền (mass assignment)
     */
    protected $fillable = [
        'name',
        'principal',
        'address',
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
