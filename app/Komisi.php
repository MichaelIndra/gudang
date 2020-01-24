<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $fillable = [
        'id_sales', 'id_trans_cust', 'id_brg', 'komisi', 'action'
    ];
}
