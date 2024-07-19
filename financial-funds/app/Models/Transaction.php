<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'type',
        'asset_type',
        'asset_id',
        'quantity',
        'price',
        'user_id'
    ];

    // Relacionamento com o modelo User (muitos para um)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    // Método para obter o ativo relacionado (Stock ou Fund) com base no tipo de ativo
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
