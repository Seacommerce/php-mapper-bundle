<?php

namespace Seacommerce\MapperBundle\Test;

use Seacommerce\Mapper\Compiler\LoaderInterface;
use Seacommerce\Mapper\Compiler\NativeCompiler;
use Seacommerce\MapperBundle\Test\Mock\Source;
use Seacommerce\MapperBundle\Test\Mock\Target;
use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\ConfigurationInterface;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BundleTest extends KernelTestCase
{
    protected static function getKernelClass()
    {
        return TestKernel::class;
    }


    public function setUp(): void
    {
        self::bootKernel();
    }

    protected function tearDown()
    {
        parent::tearDown();
        static::$class = null;
    }


    public function testServiceRegistration(): void
    {
        $this->assertTrue(self::$container->hasParameter('sc.mapper.compiler_cache_dir'));

//        $this->assertTrue(self::$container->has('sc.mapper.compiler.native'));
        $this->assertTrue(self::$container->has('sc.mapper.compiler.default'));
        $this->assertTrue(self::$container->has(CompilerInterface::class));

//        $this->assertTrue(self::$container->has('sc.mapper.loader.cached'));
        $this->assertTrue(self::$container->has('sc.mapper.loader.default'));
        $this->assertTrue(self::$container->has(LoaderInterface::class));

        $this->assertTrue(self::$container->has('sc.mapper.mapper_factory.default'));
        $this->assertTrue(self::$container->has('sc.mapper.loader.cached'));

        $this->assertTrue(self::$container->has('sc.mapper.default'));
        $this->assertTrue(self::$container->has(MapperInterface::class));

        $this->assertTrue(self::$container->has('sc.mapper.cache_warmer'));

        $this->assertFalse(self::$container->has('sc.mapper.doctrine.proxy_event_subscriber'));
    }

    public function testMappingRegistrationAutoConfiguration(): void
    {
        /** @var MapperInterface $mapper */
        $mapper = self::$container->get(MapperInterface::class);
        $this->assertInstanceOf(Mapper::class, $mapper);

        $compiler = self::$container->get(CompilerInterface::class);
        $this->assertInstanceOf(NativeCompiler::class, $compiler);

        $registry = $mapper->getRegistry();
        $this->assertEquals('default', $registry->getScope());

        $conf = $registry->get(Source::class, Target::class);
        $this->assertNotNull($conf);
        $this->assertInstanceOf(ConfigurationInterface::class, $conf);
    }
}