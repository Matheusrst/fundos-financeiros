<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'stock_id',
        'fund_id',
        'date',
        'price',
        'priceable_type',
        'priceable_id',
    ];

    // Atributos que devem ser tratados como instâncias de Carbon (data/hora)
    protected $dates = [
        'date'
    ];

    // Relacionamento com o modelo Stock (muitos para um)
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    // Relacionamento com o modelo Fund (muitos para um)
    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    // Relacionamento polimórfico com outros modelos (Stock, Fund, etc.)
    public function priceable()
    {
        return $this->morphTo();
    }
}
