<?php

namespace GazmendS\BLN\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class Ideogram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \GazmendS\BLN\Ideogram::class;
    }
}
