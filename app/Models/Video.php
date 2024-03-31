<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['entraineur_id','est_public', 'description', 'lien_aws','date_publication','titre'];

    public function entraineur()
    {
        return $this->belongsTo(Entraineur::class,'entraineur_id','id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'video_id');
    }
}


