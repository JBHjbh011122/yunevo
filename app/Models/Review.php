<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['personnel_id', 'commentaire', 'evaluation', 'date_evaluation'];

    public function user()
    {
        return $this->belongsTo(User::class, 'personnel_id');
    }
}
