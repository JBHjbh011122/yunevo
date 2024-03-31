<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entraineur extends Model
{
    protected $fillable = ['entraineur_id', 'categories_d_entraineur', 'description_d_entraineur'];

    // Définir la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class,'entraineur_id','id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'entraineur_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'entraineur_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'entraineur_id');
    }
}



