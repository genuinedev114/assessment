<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color'];


    public function stores()
    {
        return $this->hasMany(Store::class);
    }

  
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Store::class,
            'brand_id',
            'id',
            'id',
            'user_id'
        )->distinct();
    }
}
