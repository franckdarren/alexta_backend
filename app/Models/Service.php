<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
        'prix_base',
        'supplement_gabarit_id',
        'supplement_localisation_id',

    ];



    public function supplementGabarit(){
        return $this->belongsTo(SupplementGabarit::class);
    }

    public function supplementLocalisation(){
        return $this->belongsTo(SupplementGabarit::class);
    }
}
