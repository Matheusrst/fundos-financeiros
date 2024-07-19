<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($stock) {
            $stock->priceHistories()->create([
                'price' => $stock->price,
                'date' => now()
            ]);
        });

        static::updated(function ($stock) {
            $stock->priceHistories()->create([
                'price' => $stock->price,
                'date' => now()
            ]);
        });
    }

    public function transaction()
    {
        return $this->hasMany(transaction::class);
    }

    public function priceHistories()
    {
        return $this->morphMany(PriceHistory::class, 'priceable');
    }
}
