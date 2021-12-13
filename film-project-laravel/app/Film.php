<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['title', 'description', 'tahun', 'genre_id'];

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

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function peran()
    {
        return $this->hasMany(Peran::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
