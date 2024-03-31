<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progres extends Model
{
    protected $fillable = ['client_id', 'poids_actuel', 'date_de_prise'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id','id');
    }
}
