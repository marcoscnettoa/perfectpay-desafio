<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uf', 2)->unique();
            $table->string('nome', 200)->unique();
            //$table->charset     = 'utf8mb4';
            //$table->collation   = 'utf8mb4_general_ci';
        });

        // # Dados
        DB::table('estados')->insert([
                ['uf' => 'AC', 'nome' => 'Acre'],
                ['uf' => 'AL', 'nome' => 'Alagoas'],
                ['uf' => 'AP', 'nome' => 'Amapá'],
                ['uf' => 'AM', 'nome' => 'Amazonas'],
                ['uf' => 'BA', 'nome' => 'Bahia'],
                ['uf' => 'CE', 'nome' => 'Ceará'],
                ['uf' => 'DF', 'nome' => 'Distrito Federal'],
                ['uf' => 'ES', 'nome' => 'Espírito Santo'],
                ['uf' => 'GO', 'nome' => 'Goiás'],
                ['uf' => 'MA', 'nome' => 'Maranhão'],
                ['uf' => 'MT', 'nome' => 'Mato Grosso'],
                ['uf' => 'MS', 'nome' => 'Mato Grosso do Sul'],
                ['uf' => 'MG', 'nome' => 'Minas Gerais'],
                ['uf' => 'PA', 'nome' => 'Pará'],
                ['uf' => 'PB', 'nome' => 'Paraíba'],
                ['uf' => 'PR', 'nome' => 'Paraná'],
                ['uf' => 'PE', 'nome' => 'Pernambuco'],
                ['uf' => 'PI', 'nome' => 'Piauí'],
                ['uf' => 'RJ', 'nome' => 'Rio de Janeiro'],
                ['uf' => 'RN', 'nome' => 'Rio Grande do Norte'],
                ['uf' => 'RS', 'nome' => 'Rio Grande do Sul'],
                ['uf' => 'RO', 'nome' => 'Rondônia'],
                ['uf' => 'RR', 'nome' => 'Roraima'],
                ['uf' => 'SC', 'nome' => 'Santa Catarina'],
                ['uf' => 'SP', 'nome' => 'São Paulo'],
                ['uf' => 'SE', 'nome' => 'Sergipe'],
                ['uf' => 'TO', 'nome' => 'Tocantins']
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
