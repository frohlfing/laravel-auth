<?php

namespace FRohlfing\PackageSkeleton\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string foo()
 *
 * @see \FRohlfing\PackageSkeleton\PackageSkeletonService
 */
class PackageSkeletonService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \FRohlfing\PackageSkeleton\Services\PackageSkeletonService::class;
    }
}