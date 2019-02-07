<?php


namespace Seacommerce\Mapper\Bundle\Test\Mock;

use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;

class TestMappingRegistration implements MappingRegistrationInterface
{
    public function registerMappings(Registry $registry): void
    {
        $registry->add(Source::class, Target::class);
    }
}