<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiSuppGlb extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id_trans_supp';
    protected $keyType = 'string';

    protected $fillable = [
        'id_trans_supp', 'total_harga', 'diskon', 'keterangan' , 'nota_supp', 'id_supp'
    ];

    public function transSuppDets(){
        return $this->hasMany('App\TransaksiSuppGlb', 'id_trans_supp', 'id_trans_supp');
    }
}
