<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['client_id', 'lien_aws', 'date_image'];

    // Définir la relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class,"client_id",'id');
    }
}
