<?php


namespace Seacommerce\MapperBundle\DependencyInjection\Compiler;


use Doctrine\ORM\EntityManagerInterface;
use Seacommerce\MapperBundle\Doctrine\DoctrineMappingRegistration;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineIntegrationPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->has(EntityManagerInterface::class)) {
            return;
        }

        if(!$container->has(DoctrineMappingRegistration::class)) {
            return;
        }

        $container->removeDefinition(DoctrineMappingRegistration::class);
    }
}