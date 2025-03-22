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
        
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }




}
