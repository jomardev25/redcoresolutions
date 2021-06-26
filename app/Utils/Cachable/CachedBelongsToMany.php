<?php 

namespace App\Utils\Cachable;

use App\Utils\Cachable\Traits\Caching;
use App\Utils\Cachable\Traits\Buildable;
use App\Utils\Cachable\Traits\BuilderCaching;
use App\Utils\PivotEvents\Traits\FiresPivotEventsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CachedBelongsToMany extends BelongsToMany
{
    use Buildable;
    use BuilderCaching;
    use Caching;
    use FiresPivotEventsTrait;
}