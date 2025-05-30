<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdutosServicos extends Model
{
    use SoftDeletes;

    protected $table        = 'produtos_servicos';
    public $timestamps      = true;
    protected $fillable     = [];
}
