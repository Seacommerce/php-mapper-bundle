<?php

namespace Seacommerce\MapperBundle\Test;

use Doctrine\Common\Annotations\AnnotationRegistry;
use PHPUnit\Framework\TestCase;
use Seacommerce\Mapper\Compiler\NativeCompiler;
use Seacommerce\MapperBundle\CacheWarmer;
use Seacommerce\MapperBundle\Doctrine\DoctrineMappingRegistration;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity\Customer;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity\Invoice;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity\InvoiceItem;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Model\InvoiceModel;
use Seacommerce\MapperBundle\Test\Mock\Source;
use Seacommerce\MapperBundle\Test\Mock\Target;
use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\ConfigurationInterface;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Symfony\Component\Filesystem\Filesystem;

class BundleTest extends TestCase
{
    /** @var TestKernel */
    private $kernel;

    public static function setUpBeforeClass() : void
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    public function setUp()
    {
        $this->kernel = new TestKernel('test', true);
    }

    public function tearDown()
    {
        $this->kernel = new TestKernel('test', true);
        $this->kernel->shutdown();
        $fs = new Filesystem();
        $fs->remove($this->kernel->getCacheDir());
    }

    public function testServiceRegistration()
    {
        $this->kernel->boot();
        $container = $this->kernel->getContainer();

        $this->assertTrue($container->has(MapperInterface::class));
        $this->assertTrue($container->has(CompilerInterface::class));
        $this->assertTrue($container->has(CacheWarmer::class));
        $this->assertFalse($container->has(DoctrineMappingRegistration::class));

        /** @var MapperInterface $mapper */
        $mapper = $container->get(MapperInterface::class);
        $this->assertInstanceOf(Mapper::class, $mapper);

        $compiler = $container->get(CompilerInterface::class);
        $this->assertInstanceOf(NativeCompiler::class, $compiler);
        $this->assertEquals($this->kernel->getCacheDir() . '/seacommerce/mapper/', $compiler->getCacheFolder());


        $registry = $mapper->getRegistry();
        $this->assertEquals('default', $registry->getScope());

        $conf = $registry->get(Source::class, Target::class);
        $this->assertNotNull($conf);
        $this->assertInstanceOf(ConfigurationInterface::class, $conf);
    }

    /**
     */
    public function testDoctrineIntegration()
    {
        $this->kernel->enableDoctrineBundle();
        $this->kernel->boot();

        $container = $this->kernel->getContainer();
        $this->assertTrue($container->has(DoctrineMappingRegistration::class));

        /** @var MapperInterface $mapper */
        $mapper = $container->get(MapperInterface::class);
        $registry = $mapper->getRegistry();

        $entity = new Invoice();
        $entity->setId(1);
        $entity->setCustomer((new Customer())->setId(100)->setName("Customer #100"));
        $entity->getItems()->add(new InvoiceItem());
        $entity->getItems()->add(new InvoiceItem());
//        $target = $mapper->map($entity, InvoiceModel::class);
    }
}