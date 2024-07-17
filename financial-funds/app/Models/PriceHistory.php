<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'fund_id',
        'date',
        'price',
    ];

    protected $dates = [
        'date'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
