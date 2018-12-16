<?php

namespace FRohlfing\PackageSkeleton\Services;

use FRohlfing\PackageSkeleton\Contracts\PackageSkeletonServiceContract;

class PackageSkeletonService implements PackageSkeletonServiceContract
{
    protected $foo;

    /**
     * PackageSkeleton constructor.
     *
     * @param string $foo
     */
    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    /**
     * @inheritdoc
     */
    public function foo()
    {
        return $this->foo;
    }
}