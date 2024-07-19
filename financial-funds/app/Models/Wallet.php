<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'balance',
    ];

    // Relacionamento com o modelo User (muitos para um)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
