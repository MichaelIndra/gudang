<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_cust';
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_cust', 'nama_cust', 'alamat', 'telp', 'term'
    ];
}
