<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harga_Cust extends Model
{
    protected $table='harga_custs';
    protected $primaryKey = 'id_brg';
    
    protected $fillable = [
        'id_brg', 'harga', 'id_cust', 'komisi'
    ];
}
