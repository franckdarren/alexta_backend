<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplementGabarit extends Model
{
    //

    protected $fillable = [
        'type',
        'montant',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    


}
