<?php


namespace Seacommerce\Mapper\Bundle\Test\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Seacommerce\Mapper\Bundle\DependencyInjection\BundleExtension;
use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\Compiler\PropertyAccessCompiler;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\Mapper\Registry;
use Seacommerce\Mapper\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BundleExtensionTest extends TestCase
{
    public function testExtensionLoad()
    {
        $container = new ContainerBuilder();
        $extension = new BundleExtension();
        $extension->load([], $container);

        $this->assertNotNull($container->getDefinition(Registry::class));
        $this->assertNotNull($container->getAlias(RegistryInterface::class));
        $this->assertNotNull($container->getDefinition(Mapper::class));
        $this->assertNotNull($container->getAlias(MapperInterface::class));
        $this->assertNotNull($container->getDefinition(PropertyAccessCompiler::class));
        $this->assertNotNull($container->getAlias(CompilerInterface::class));
    }
}