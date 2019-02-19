<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function children()
    {
        return $this->hasMany('App\Models\Experiment', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Experiment', 'parent_id');
    }

    public function results()
    {
        return $this->hasOne('App\Models\Result');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
