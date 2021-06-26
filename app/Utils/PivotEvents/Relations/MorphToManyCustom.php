<?php 

namespace App\Utils\PivotEvents\Relations;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Utils\PivotEvents\Traits\FiresPivotEventsTrait;

class MorphToManyCustom extends MorphToMany
{
    use FiresPivotEventsTrait;
}