<?php


namespace Seacommerce\MapperBundle\Test\DoctrineIntegration\Mapping;


use Seacommerce\Mapper\Operation;
use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Model\UserType;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity\UserTypeEntity;

class DoctrineMapping implements MappingRegistrationInterface
{
    public function registerValueConverters(Registry $registry): void
    {
        // TODO: Implement registerValueConverters() method.
    }

    public function registerMappings(Registry $registry): void
    {
        $registry->add(UserTypeEntity::class, UserType::class)
            ->autoMap();

        $registry->add(UserType::class, UserTypeEntity::class)
            ->autoMap()
            ->forMember('users', Operation::ignore());
    }
}