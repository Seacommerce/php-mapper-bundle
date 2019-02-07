<?php

namespace Seacommerce\MapperBundle;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class CacheWarmer implements CacheWarmerInterface
{
    /**
     * @var DefaultMapperFactory
     */
    private $factory;

    public function __construct(DefaultMapperFactory $factory)
    {
        $this->factory = $factory;
    }

    public function isOptional()
    {
        return true;
    }

    public function warmUp($cacheDir)
    {
        $mapper = $this->factory->create();
    }
}