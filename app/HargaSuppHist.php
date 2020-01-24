<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HargaSuppHist extends Model
{
    protected $fillable = [
        'id_brg', 'harga', 'keterangan'
    ];
}
