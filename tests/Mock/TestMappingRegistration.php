<?php


namespace Seacommerce\MapperBundle\Test\Mock;

use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;

class TestMappingRegistration implements MappingRegistrationInterface
{
    /**
     * @param Registry $registry
     * @throws \Exception
     */
    public function registerMappings(Registry $registry): void
    {
        $registry->add(Source::class, Target::class)
            ->automap();
    }

    public function registerValueConverters(Registry $registry): void
    {
        $registry->registerDefaultValueConverters();
    }
}