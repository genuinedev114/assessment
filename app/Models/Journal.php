<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'date', 'revenue', 'food_cost', 'labor_cost', 'profit'];

    protected $dates = ['date'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
