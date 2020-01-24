<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiSuppDet extends Model
{
    protected $fillable = [
        'qty', 'harga_satuan', 'harga_total', 'id_trans_supp' , 'id_brg'
    ];

    public function transSuppGlb(){
        return $this->belongsTo('App\TransaksiSuppDet');
        
    }

}
