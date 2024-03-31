<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['client_id', 'entraineur_id', 'video_id', 'date_commande'];


    public function entraineur()
    {
        return $this->belongsTo(Entraineur::class, 'entraineur_id','id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id','id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id','id');
    }
}




