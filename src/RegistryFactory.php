<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\Mapper\Registry;
use Seacommerce\Mapper\RegistryInterface;

class RegistryFactory
{
    /**
     * @var MappingRegistrationInterface[]
     */
    private $registrations;
    /**
     * @var string
     */
    private $scope;

    public function __construct(string $scope, iterable $registrations)
    {
        $this->scope = $scope;
        $this->registrations = $registrations;
    }

    /**
     * @return RegistryInterface
     * @throws \Exception
     */
    public function getRegistry(): RegistryInterface
    {
        static $registry;
        if ($registry == null) {
            $registry = new Registry($this->scope);
            foreach ($this->registrations as $registration) {
                $registration->registerMappings($registry);
            }
        }
        return $registry;
    }
}