<?php

namespace App\Traits;

use Closure;
use Illuminate\Support\Facades\DB;

trait DBTrait
{
    public static function beginTransaction(string $connection = 'mysql')
    {
        DB::connection($connection)->beginTransaction();
    }

    public static function commit(string $connection = 'mysql')
    {
        DB::connection($connection)->commit();
    }

    public static function rollBack(string $connection = 'mysql')
    {
        DB::connection($connection)->rollBack();
    }

    public static function transaction(Closure $closure, string $connection = 'mysql')
    {
        DB::connection($connection)->transaction($closure);
    }
}
