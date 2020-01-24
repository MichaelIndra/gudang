<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_sales';
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_sales', 'nama_sales', 'alamat', 'telp'
    ];
}
