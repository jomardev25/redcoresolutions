<?php

namespace App\Models;

use App\Utils\Cachable\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RequestFilter;

class Role extends Model
{
    use Cachable, SoftDeletes, RequestFilter;

    protected $fillable = ["name", "description"];
    protected $filterFields = ["name", "description"];
}
