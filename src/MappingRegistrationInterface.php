<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\Mapper\Registry;

interface MappingRegistrationInterface
{
    public function registerValueConverters(Registry $registry): void;

    public function registerMappings(Registry $registry): void;
}