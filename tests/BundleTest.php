<?php

namespace Seacommerce\MapperBundle\Test;

use PHPUnit\Framework\TestCase;
use Seacommerce\MapperBundle\Test\Mock\Source;
use Seacommerce\MapperBundle\Test\Mock\Target;
use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\Compiler\PropertyAccessCompiler;
use Seacommerce\Mapper\ConfigurationInterface;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\Mapper\Registry;
use Seacommerce\Mapper\RegistryInterface;

class BundleTest extends TestCase
{
    public function testServiceRegistration()
    {
        $kernel = new TestKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $this->assertTrue($container->has(MapperInterface::class));
        $this->assertTrue($container->has(CompilerInterface::class));
        $this->assertTrue($container->has(RegistryInterface::class));

        $mapper = $container->get(MapperInterface::class);
        $this->assertInstanceOf(Mapper::class, $mapper);

        $compiler = $container->get(CompilerInterface::class);
        $this->assertInstanceOf(PropertyAccessCompiler::class, $compiler);

        $registry = $container->get(RegistryInterface::class);
        $this->assertInstanceOf(Registry::class, $registry);
        $this->assertEquals('default', $registry->getScope());

        $conf = $registry->get(Source::class, Target::class);
        $this->assertNotNull($conf);
        $this->assertInstanceOf(ConfigurationInterface::class, $conf);
    }
}