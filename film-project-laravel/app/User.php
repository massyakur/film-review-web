<?php

namespace App;

use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'email_verified_at'
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

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function otp_code()
    {
        return $this->hasOne(OtpCode::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function film()
    {
        return $this->hasOne('App\Film');
    }

    public function genre()
    {
        return $this->hasOne('App\Genre');
    }

    public function cast()
    {
        return $this->hasOne('App\Cast');
    }

    public function peran()
    {
        return $this->hasOne('App\Peran');
    }

    public function gen_film()
    {
        return $this->hasOne('App\GenreFilm');
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
