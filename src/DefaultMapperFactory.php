<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\Mapper\Registry;

class DefaultMapperFactory
{
    /**
     * @var MappingRegistrationInterface[]
     */
    private $registrations;
    /**
     * @var CompilerInterface
     */
    private $compiler;

    public function __construct(CompilerInterface $compiler, iterable $registrations)
    {
        $this->registrations = $registrations;
        $this->compiler = $compiler;
    }

    /**
     * @return MapperInterface
     * @throws \Exception
     */
    public function create(): MapperInterface
    {
        $registry = new Registry('default');
        foreach ($this->registrations as $registration) {
            $registration->registerValueConverters($registry);
        }
        foreach ($this->registrations as $registration) {
            $registration->registerMappings($registry);
        }

        $registry->validate();
        $mapper = new Mapper($registry, $this->compiler);
        $mapper->compile();
        return $mapper;
    }
}