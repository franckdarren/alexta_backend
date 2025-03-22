<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    
    use HasFactory;


    protected $fillable = ['status', 'localisation', 'prix_total', 'service_id', 'user_id', 'supplement_gabarit_id', 'supplement_localisation_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function supplementGabarit()
    {
        return $this->belongsTo(SupplementGabarit::class);
    }

    public function supplementLocalisation()
    {
        return $this->belongsTo(SupplementLocalisation::class);
    }
}
