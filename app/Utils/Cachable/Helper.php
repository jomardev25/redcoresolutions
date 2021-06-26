<?php

namespace App\Utils\Cachable;

use Illuminate\Container\Container;

class Helper
{
    public function runDisabled(callable $closure)
    {
        $originalSetting = Container::getInstance()
            ->make("config")
            ->get('hrms-model-caching.enabled');

        Container::getInstance()
            ->make("config")
            ->set(['hrms-model-caching.enabled' => false]);

        $result = $closure();

        Container::getInstance()
            ->make("config")
            ->set(['hrms-model-caching.enabled' => $originalSetting]);

        return $result;
    }
}