<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_supp';
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_supp', 'nama_supp', 'alamat', 'telp'
    ];

    public function barangs(){
        return $this->hasMany('App\Barang', 'id_supp', 'id_supp');
    }
}
