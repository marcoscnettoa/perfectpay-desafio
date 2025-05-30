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
        Schema::create('produtos_servicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chave', 200)->unique()->nullable();
            $table->string('nome', 200)->nullable();
            $table->string('descricao', 1000)->nullable();
            $table->decimal('valor', 20, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->index()->nullable();
            //$table->charset     = 'utf8mb4';
            //$table->collation   = 'utf8mb4_general_ci';
        });

        // # Dados
        DB::table('produtos_servicos')->insert([
            [
                'id'            => 1,
                'chave'         => 'PRODUTO-1',
                'nome'          => 'Produto 1',
                'descricao'     => 'Teste tipo de produto 1',
                'valor'         => 150.00,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'id'            => 2,
                'chave'         => 'PRODUTO-2',
                'nome'          => 'Produto 2',
                'descricao'     => 'Teste tipo de produto 2',
                'valor'         => 299.00,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'id'            => 3,
                'chave'         => 'SERVICO-1',
                'nome'          => 'Serviço 1',
                'descricao'     => 'Teste tipo de Serviço 1',
                'valor'         => 355.00,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'id'            => 4,
                'chave'         => 'SERVICO-2',
                'nome'          => 'Serviço 2',
                'descricao'     => 'Teste tipo de Serviço 2',
                'valor'         => 1230.00,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_servicos');
    }
};
