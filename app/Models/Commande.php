<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    //


    protected $fillable = [
        'status',
        'localisation',
        'prix_total',
        'service_id',
        'user_id',

    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
