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

    ];
}
