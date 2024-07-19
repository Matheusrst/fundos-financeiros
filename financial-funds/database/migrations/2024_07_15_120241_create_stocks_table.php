<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'stocks' com os campos necessários.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('available_quantity')->default(0);
            $table->timestamps();
        });
    }

     /**
     * Reverte a criação da tabela 'stocks'.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
