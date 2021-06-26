<?php namespace App\Utils\Cachable\Traits;

use Closure;
use Illuminate\Support\Carbon;
use App\Utils\Cachable\CacheKey;
use Illuminate\Cache\TaggableStore;
use Illuminate\Container\Container;
use App\Utils\Cachable\CachedBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Utils\Cachable\CacheTags;

trait Caching
{
    protected $isCachable = true;
    protected $scopesAreApplied = false;
    protected $macroKey = "";

    public function __call($method, $parameters)
    {
        $result = parent::__call($method, $parameters);

        if (isset($this->localMacros[$method])) {
            $this->macroKey .= "-{$method}";

            if ($parameters) {
                $this->macroKey .= implode("_", $parameters);
            }
        }

        return $result;
    }

    public function applyScopes()
    {
        if ($this->scopesAreApplied) {
            return $this;
        }
        
        return parent::applyScopes();
    }

    protected function applyScopesToInstance()
    {
        if (! property_exists($this, "scopes")
            || $this->scopesAreApplied
        ) {
            return;
        }

        foreach ($this->scopes as $identifier => $scope) {
            if (! isset($this->scopes[$identifier])) {
                continue;
            }

            $this->callScope(function () use ($scope) {
                if ($scope instanceof Closure) {
                    $scope($this);
                }

                if ($scope instanceof Scope
                    && $this instanceof CachedBuilder
                ) {
                    $scope->apply($this, $this->getModel());
                }
            });
        }

        $this->scopesAreApplied = true;
    }

    public function cache(array $tags = [])
    {
        $cache = Container::getInstance()
            ->make("cache");
        $config = Container::getInstance()
            ->make("config")
            ->get("hrms-model-caching.store");

        if ($config) {
            $cache = $cache->store($config);
        }

        if (is_subclass_of($cache->getStore(), TaggableStore::class)) {
            $cache = $cache->tags($tags);
        }

        return $cache;
    }

    public function disableModelCaching()
    {
        $this->isCachable = false;

        return $this;
    }

    public function flushCache(array $tags = [])
    {
        if (count($tags) === 0) {
            $tags = $this->makeCacheTags();
        }

        $this->cache($tags)->flush();
        list($cacheCooldown) = $this->getModelCacheCooldown($this);

        if ($cacheCooldown) {
            $cachePrefix = $this->getCachePrefix();
            $modelClassName = get_class($this);
            $cacheKey = "{$cachePrefix}:{$modelClassName}-cooldown:saved-at";

            $this->cache()
                ->rememberForever($cacheKey, function () {
                    return (new Carbon)->now();
                });
        }
    }

    protected function getCachePrefix() : string
    {
        $cachePrefix = Container::getInstance()
            ->make("config")
            ->get("hrms-model-caching.cache-prefix", "");

        if ($this->model
            && property_exists($this->model, "cachePrefix")
        ) {
            $cachePrefix = $this->model->cachePrefix;
        }

        $cachePrefix = $cachePrefix
            ? "{$cachePrefix}:"
            : "";

        return "hrms:hrms-model-caching:"
            . $cachePrefix;
    }

    protected function makeCacheKey(
        array $columns = ['*'],
        $idColumn = null,
        string $keyDifferentiator = ''
    ) : string {
        $this->applyScopesToInstance();
        $eagerLoad = $this->eagerLoad ?? [];
        $model = $this;

        if (property_exists($this, "model")) {
            $model = $this->model;
        }

        if (method_exists($this, "getModel")) {
            $model = $this->getModel();
        }

        $query = $this->query
            ?? Container::getInstance()
                ->make("db")
                ->query();
        
        if ($this->query
            && method_exists($this->query, "getQuery")
        ) {
            $query = $this->query->getQuery();
        }

        return (new CacheKey($eagerLoad, $model, $query, $this->macroKey))
            ->make($columns, $idColumn, $keyDifferentiator);
    }

    protected function makeCacheTags() : array
    {
        $eagerLoad = $this->eagerLoad ?? [];
        $model = $this->getModel() instanceof Model
            ? $this->getModel()
            : $this;
        $query = $this->query instanceof Builder
            ? $this->query
            : Container::getInstance()
                ->make("db")
                ->query();
        $tags = (new CacheTags($eagerLoad, $model, $query))
            ->make();

        return $tags;
    }

    public function getModelCacheCooldown(Model $instance) : array
    {
        if (! $instance->cacheCooldownSeconds) {
            return [null, null, null];
        }

        $cachePrefix = $this->getCachePrefix();
        $modelClassName = get_class($instance);
        list($cacheCooldown, $invalidatedAt, $savedAt) = $this->getCacheCooldownDetails($instance, $cachePrefix, $modelClassName);

        if (! $cacheCooldown || $cacheCooldown === 0) {
            return [null, null, null];
        }

        return [$cacheCooldown, $invalidatedAt, $savedAt];
    }

    protected function getCacheCooldownDetails(
        Model $instance,
        string $cachePrefix,
        string $modelClassName
    ) : array {
        return [
            $instance
                ->cache()
                ->get("{$cachePrefix}:{$modelClassName}-cooldown:seconds"),
            $instance
                ->cache()
                ->get("{$cachePrefix}:{$modelClassName}-cooldown:invalidated-at"),
            $instance
                ->cache()
                ->get("{$cachePrefix}:{$modelClassName}-cooldown:saved-at"),
        ];
    }

    protected function checkCooldownAndRemoveIfExpired(Model $instance)
    {
        list($cacheCooldown, $invalidatedAt) = $this->getModelCacheCooldown($instance);

        if (! $cacheCooldown
            || (new Carbon)->now()->diffInSeconds($invalidatedAt) < $cacheCooldown
        ) {
            return;
        }

        $cachePrefix = $this->getCachePrefix();
        $modelClassName = get_class($instance);

        $instance
            ->cache()
            ->forget("{$cachePrefix}:{$modelClassName}-cooldown:seconds");
        $instance
            ->cache()
            ->forget("{$cachePrefix}:{$modelClassName}-cooldown:invalidated-at");
        $instance
            ->cache()
            ->forget("{$cachePrefix}:{$modelClassName}-cooldown:saved-at");
        $instance->flushCache();
    }

    protected function checkCooldownAndFlushAfterPersisting(Model $instance, string $relationship = "")
    {
        list($cacheCooldown, $invalidatedAt) = $instance->getModelCacheCooldown($instance);

        if (! $cacheCooldown) {
            $instance->flushCache();

            if ($relationship) {
                $relationshipInstance = $instance->$relationship()->getModel();

                if (method_exists($relationshipInstance, "flushCache")) {
                    $relationshipInstance->flushCache();
                }
            }

            return;
        }

        $this->setCacheCooldownSavedAtTimestamp($instance);

        if ((new Carbon)->now()->diffInSeconds($invalidatedAt) >= $cacheCooldown) {
            $instance->flushCache();

            if ($relationship) {
                $instance->$relationship()->getModel()->flushCache();
            }
        }
    }

    public function isCachable() : bool
    {
        $isCacheDisabled = ! Container::getInstance()
            ->make("config")
            ->get("hrms-model-caching.enabled");
        $allRelationshipsAreCachable = true;

        if (property_exists($this, "eagerLoad")
            && $this->eagerLoad
        ) {
            $allRelationshipsAreCachable = collect($this
                ->eagerLoad)
                ->keys()
                ->reduce(function ($carry, $related) {
                    if (! method_exists($this, $related)
                        || $carry === false
                    ) {
                        return $carry;
                    }
        
                    $relatedModel = $this->model->$related()->getRelated();

                    if (! method_exists($relatedModel, "isCachable")
                        || ! $relatedModel->isCachable()
                    ) {
                        return false;
                    }

                    return true;
                })
                ?? true;
        }

        return $this->isCachable
            && ! $isCacheDisabled
            && $allRelationshipsAreCachable;
    }

    protected function setCacheCooldownSavedAtTimestamp(Model $instance)
    {
        $cachePrefix = $this->getCachePrefix();
        $modelClassName = get_class($instance);
        $cacheKey = "{$cachePrefix}:{$modelClassName}-cooldown:saved-at";

        $instance->cache()
            ->rememberForever($cacheKey, function () {
                return (new Carbon)->now();
            });
    }
}