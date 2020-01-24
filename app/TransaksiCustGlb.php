<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiCustGlb extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_trans_cust';
    protected $keyType = 'string';

    protected $fillable = [
        'id_trans_cust', 'total_harga', 'diskon', 'keterangan' , 'status', 'id_sales', 'id_cust', 'id_user'
    ];        
}
