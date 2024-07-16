<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'asset_type',
        'asset_id',
        'quantity',
        'price',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    public function asset()
    {
        if ($this->asset_type === 'stock') {
            return $this->stock();
        } elseif ($this->asset_type === 'fund') {
            return $this->fund();
        }
        return null;
    }
}
