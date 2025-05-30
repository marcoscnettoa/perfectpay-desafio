<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsaasCobrancas extends Model
{

    use SoftDeletes;

    protected $table        = 'asaas_cobrancas';
    public $timestamps      = true;
    protected $fillable     = [];

    // :: HASH ::
    public static function boot() {
        parent::boot();
        static::saving(function($model) {
           if(empty($model->hash)){
               $model->hash = self::generateUniqueHash();
           }
        });
    }

    public static function generateUniqueHash() {
        do {
            $hash = bin2hex(random_bytes(16));
        }while(self::hashExists($hash));
        return $hash;
    }

    private static function hashExists(string $hash): bool {
        return self::where('hash',$hash)->exists();
    }
    // - ::

}
