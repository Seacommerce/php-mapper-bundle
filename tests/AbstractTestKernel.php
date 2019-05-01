<?php


namespace Seacommerce\MapperBundle\Test;


use Symfony\Component\HttpKernel\Kernel;

abstract class AbstractTestKernel extends Kernel
{
    public function getCacheDir()
    {
        $refClass = new \ReflectionClass(static::class);
        $cacheDir = parent::getCacheDir() . '/' . $refClass->getShortName();
        return $cacheDir;
    }
}