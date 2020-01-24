<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $fillable = [
        'keterangan', 'qty', 'status', 'id_brg', 'id_trans_cust', 'action'
    ];
}
