<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HargaSupp extends Model
{
    protected $primaryKey = 'id_brg';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_brg', 'harga'
    ];
}
