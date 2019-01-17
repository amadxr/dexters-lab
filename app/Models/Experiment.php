<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $fillable = ['title', 'background', 'falsifiable_hypothesis', 'details', 'results', 'validated_learning', 'next_action'];

    protected $dates = ['created_at', 'updated_at'];
}
