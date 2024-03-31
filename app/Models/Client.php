<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['client_id', 'poids_depart', 'poids_souhait', 'taille'];

    // Définir la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id','id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class,'client_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function progres()
    {
        return $this->hasMany(Progres::class, 'client_id');
    }
}
