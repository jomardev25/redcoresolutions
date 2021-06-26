<?php 

namespace App\Utils\Cachable;

use App\Utils\Cachable\Traits\Caching;
use App\Utils\Cachable\Traits\Buildable;
use App\Utils\Cachable\Traits\BuilderCaching;
use Illuminate\Database\Eloquent\Builder;

class CachedBuilder extends Builder
{
    use Buildable;
    use BuilderCaching;
    use Caching;
}