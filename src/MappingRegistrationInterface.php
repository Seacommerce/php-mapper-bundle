<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\Mapper\Registry;

interface MappingRegistrationInterface
{
    public function registerMappings(Registry $registry): void;
}