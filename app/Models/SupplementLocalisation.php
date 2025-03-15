<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplementLocalisation extends Model
{
    //

    protected $fillable = [
        'lieu',
        'montant',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }



}
