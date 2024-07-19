<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'funds' com os campos necessários.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('available_quantity')->default(999);
            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela 'funds'.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
