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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($fund) {
            $fund->priceHistories()->create([
                'price' => $fund->price,
                'date' => now()
            ]);
        });

        static::updated(function ($fund) {
            $fund->priceHistories()->create([
                'price' => $fund->price,
                'date' => now()
            ]);
        });
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function priceHistories()
    {
        return $this->morphMany(PriceHistory::class, 'priceable');
    }
}
