<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $fillable = ['name', 'age', 'bio'];

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

    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
