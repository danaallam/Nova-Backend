<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile', 'resume', 'experience', 'phone', 'link'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function rating(){
        return $this->hasMany(Rating::class, 'freelancer_id', 'id');
    }

    public function savedCards(){
        return $this->hasMany(Saved::class, 'freelancer_id', 'id');
    }

    public function application(){
        return $this->hasMany(FreelancerCard::class, 'freelancer_id', 'id');
    }

    public function category(){
        return $this->hasMany(FreelancerCategory::class, 'freelancer_id', 'id');
    }

    public function posts(){
        return $this->hasMany(UserPost::class, 'freelancer_id', 'id');
    }

}
