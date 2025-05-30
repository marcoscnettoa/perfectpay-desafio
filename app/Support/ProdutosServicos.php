<?php
namespace App\Support;

class ProdutosServicos
{
    // # Lista Produto(s) / Serviço(s)
    public static function all() {
        return [
            ['chave' => 'PRODUTO-1', 'nome' => 'Produto 1', 'descricao' => 'Teste tipo de produto 1', 'valor' => '150,00'],
            ['chave' => 'PRODUTO-2', 'nome' => 'Produto 2', 'descricao' => 'Teste tipo de Produto 2', 'valor' => '299,00'],
            ['chave' => 'SERVICO-1', 'nome' => 'Serviço 1', 'descricao' => 'Teste tipo de Serviço 1', 'valor' => '355,00'],
            ['chave' => 'SERVICO-2', 'nome' => 'Serviço 2', 'descricao' => 'Teste tipo de Serviço 2', 'valor' => '1230,00']
        ];
    }

    // # Seleção/Retorno - Produto ou Serviço - Chave Identificador
    public static function findByKey($chave) {
        return collect(self::all())->firstWhere('chave',$chave);
    }

    // # !
    public static function keys() {
        return collect(self::all())->pluck('chave');
    }
}
