<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_brg';
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_brg', 'nama_brg', 'keterangan' , 'id_supp'
    ];

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function stok(){
        return $this->belongsTo('App\Supplier', 'id_brg');
    }
}
