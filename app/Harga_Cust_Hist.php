<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harga_Cust_Hist extends Model
{
    protected $table='harga_cust_hists';
    protected $fillable = [
        'id_brg', 'harga', 'keterangan', 'id_cust', 'komisi'
    ];
}
