<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $fillable = ['title', 'background', 'falsifiable_hypothesis', 'details', 'results', 'validated_learning', 'next_action', 'parent_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function children()
    {
        return $this->hasMany('App\Models\Experiment', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Experiment', 'parent_id');
    }
}
