<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsaasClientes extends Model
{
    use SoftDeletes;

    protected $table        = 'asaas_clientes';
    public $timestamps      = true;
    protected $fillable     = [];
}
