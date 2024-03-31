<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['entraineur_id', 'date_publication', 'texte', 'titre', 'lien_aws_photo_blog'];

    public function entraineur()
    {
        return $this->belongsTo(Entraineur::class, 'entraineur_id','id');
    }
}
