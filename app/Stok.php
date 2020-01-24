<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    
    protected $fillable = [
        'id_brg', 'qty', 'transaksi', 'action'
    ];

    public function barangs(){
        return $this->hasMany('App\Barang', 'id_brg', 'id_brg');
    }
}
