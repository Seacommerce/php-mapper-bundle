<?php

namespace Seacommerce\MapperBundle;

use Psr\Log\LoggerInterface;
use Seacommerce\Mapper\Compiler\LoaderInterface;
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
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var LoaderInterface
     */
    private $loader;

    public function __construct(LoaderInterface $loader, LoggerInterface $logger, iterable $registrations)
    {
        $this->registrations = $registrations;
        $this->logger = $logger;
        $this->loader = $loader;
    }

    /**
     * @return MapperInterface
     * @throws \Exception
     */
    public function create(): MapperInterface
    {
        $registry = new Registry('default');

        $start = microtime(true);
        foreach ($this->registrations as $registration) {
            $registration->registerValueConverters($registry);
        }

        foreach ($this->registrations as $registration) {
            $registration->registerMappings($registry);
        }
        $end = microtime(true);

        $duration = round(($end - $start)  / 1000, 2);
        $this->logger->debug("Mapping registration finished in {$duration} ms.");

        $mapper = new Mapper($registry, $this->loader);
        return $mapper;
    }
}