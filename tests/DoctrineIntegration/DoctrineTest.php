<?php

namespace Seacommerce\MapperBundle\Test\DoctrineIntegration;

use Doctrine\ORM\EntityManagerInterface;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity\UserEntity;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Model\UserType;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity\UserTypeEntity;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Mapping\DoctrineMapping;
use Seacommerce\MapperBundle\Test\TestingTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineTest extends KernelTestCase
{
    use TestingTrait;

    protected static function getKernelClass()
    {
        return DoctrineTestKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }

    protected function tearDown()
    {
        parent::tearDown();
        static::$class = null;
    }

    public function testServiceRegistration()
    {
        $this->assertEquals('CustomProxies', self::$container->getParameter('mapper.doctrine.proxy_namespace'));
        $this->assertTrue(self::$container->has('sc.mapper.doctrine.proxy_event_subscriber'));

        $this->assertTrue(self::$container->has(DoctrineMapping::class));

        $proxyEventSubscriber = self::$container->get('sc.mapper.doctrine.proxy_event_subscriber');
        $this->assertEquals('CustomProxies', $proxyEventSubscriber->getProxyNamespace());
    }

    public function testProxyResolve(): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::$container->get('doctrine.orm.entity_manager');

        /** @var MapperInterface $mapper */
        $mapper = self::$container->get('sc.mapper.default');

        self::createSchema($em);

        $userType = (new UserTypeEntity())->setId(1)->setCode('U')->setName('Regular user');
        $user = (new UserEntity())->setId(1)->setEmail("test@seacommerce.nl")->setType($userType);
        $em->persist($userType);
        $em->persist($user);
        $em->flush();
        $em->clear();

        $user = $em->find(UserEntity::class, 1);
        $userType = $user->getType();
        $this->assertInstanceOf('CustomProxies\__CG__\Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity\UserTypeEntity', $userType);

        /** @var UserType $model */
        $model = $mapper->map($userType, UserType::class);

        $model->setName('Regular');

        /** @var UserTypeEntity $userType */
        $userType = $mapper->map($model, UserTypeEntity::class);
        $this->assertEquals('Regular', $userType->getName());
    }
}