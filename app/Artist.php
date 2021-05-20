<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use  SoftDeletes;
    protected $table = 'artists';
    protected $guarded = ['id'];

    public function songs() : HasMany
    {
        return $this->hasMany('Song');
    }
}
