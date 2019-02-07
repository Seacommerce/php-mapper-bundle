<?php


namespace Seacommerce\MapperBundle\DependencyInjection\Compiler;


use Seacommerce\MapperBundle\MappingRegistrationInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TagRegistrationsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $definition) {
            $class = $definition->getClass();
            if (!class_exists($class)) {
                continue;
            }
            if (!is_subclass_of($class, MappingRegistrationInterface::class)) {
                continue;
            }
            if ($definition->hasTag('mapper.mapping_registration')) {
                continue;
            }
            $definition->addTag('mapper.mapping_registration');
        }
    }
}