<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $fillable = ['film_id', 'cast_id', 'name'];

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

    public function cast()
    {
        return $this->belongsTo(Cast::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
