<?php


namespace Seacommerce\Mapper\Bundle\Test;

use PHPUnit\Framework\TestCase;
use Seacommerce\Mapper\Bundle\MapperBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BundleTest extends TestCase
{
    public function testBundle()
    {
        $container = new ContainerBuilder();
        $bundle    = new MapperBundle();
        $bundle->build($container);
        $this->assertNotNull($bundle);
    }
}