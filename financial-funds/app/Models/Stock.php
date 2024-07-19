<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'price',
    ];

    // Métodos de inicialização de eventos do modelo
    protected static function boot()
    {
        parent::boot();

        // Evento disparado quando uma nova ação é criada
        static::created(function ($stock) {
            $stock->priceHistories()->create([
                'price' => $stock->price,
                'date' => now()
            ]);
        });

        // Evento disparado quando uma ação existente é atualizada
        static::updated(function ($stock) {
            $stock->priceHistories()->create([
                'price' => $stock->price,
                'date' => now()
            ]);
        });
    }

    // Relacionamento com o modelo Transaction (muitos para um)
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relacionamento polimórfico com o modelo PriceHistory (muitos para um)
    public function priceHistories()
    {
        return $this->morphMany(PriceHistory::class, 'priceable');
    }
}
