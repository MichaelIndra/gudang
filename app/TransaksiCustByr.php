<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiCustByr extends Model
{
    protected $fillable = [
        'status', 'metode', 'term', 'id_cust' , 'id_trans_cust', 'bayar'
    ];
}
