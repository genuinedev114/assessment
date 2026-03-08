<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'number', 'address', 'city', 'state', 'zip_code'];

 
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

 
    public function owners()
    {
        return $this->belongsToMany(User::class, 'store_user')->withTimestamps();
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function getTotalRevenueAttribute()
    {
        return $this->journals()->sum('revenue');
    }

 
    public function getTotalProfitAttribute()
    {
        return $this->journals()->sum('profit');
    }
}
