<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['title', 'description', 'tahun'];

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

    public function peran()
    {
        return $this->hasMany(Peran::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function genre_film()
    {
        return $this->hasMany(GenreFilm::class);
    }

    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
