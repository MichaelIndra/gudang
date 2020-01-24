<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiCustDet extends Model
{
    protected $fillable = [
        'qty', 'harga_satuan', 'harga_total', 'komisi' , 'id_trans_cust', 'id_brg', 'statuskomisi'
    ];        
}
