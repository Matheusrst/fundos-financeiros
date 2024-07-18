<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function priceHistories()
    {
        return $this->morphMany(PriceHistory::class, 'priceable');
    }
}
