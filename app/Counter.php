<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'nama';
    protected $keyType = 'string';
    
    protected $fillable = [
        'nama', 'counter', 'created_at', 'updated_at'
    ];

    protected $dates = ['updated_at'];
}
