<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'user_type',
        'password',
        'est_actif',
        'lien_aws_photo_compte',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //Dans le modèle Utilisateur
    public function entraineur()
    {
        return $this->hasOne(Entraineur::class, 'entraineur_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasOne(Review::class, 'personnel_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'expediteur_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'destinataire_id');
    }

    public function isClient() {
        return $this->user_type === 'client';
    }

    public function isEntraineur() {
        return $this->user_type === 'entraineur';
    }
}


