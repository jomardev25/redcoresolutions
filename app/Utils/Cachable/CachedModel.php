<?php 

namespace App\Utils\Cachable;

use App\Utils\Cachable\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

abstract class CachedModel extends Model
{
    use Cachable;
}