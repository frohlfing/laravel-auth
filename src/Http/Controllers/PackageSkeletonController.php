<?php

namespace FRohlfing\PackageSkeleton\Http\Controllers;

use App\Http\Controllers\Controller;
use FRohlfing\PackageSkeleton\Facades\PackageSkeletonService;

class PackageSkeletonController extends Controller
{
    public function index()
    {
        // get the service from service container
        //$foo = app(\FRohlfing\PackageSkeleton\Services\PackageSkeletonService::class)->foo();

        // get the service via Facade
        $foo = PackageSkeletonService::foo();

        // get the service via Alias
        //$foo = \PackageSkeletonServiceAlias::foo();

        $bar = config('package-skeleton.foo_bar');

        return view('package-skeleton::index', compact('foo', 'bar'));
    }
}