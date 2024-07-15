<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'available_quantity'
    ];

    public function transaction()
    {
        return $this->hasMany(transaction::class);
    }
}
