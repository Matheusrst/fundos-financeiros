<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'price_histories' para armazenar os históricos de preços.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('price_histories', function (Blueprint $table) {
            $table->id();
            $table->morphs('priceable'); // priceable_id e priceable_type
            $table->decimal('price', 8, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela 'price_histories'.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('price_histories');
    }
};
