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
            if (!class_exists($class, false)) {
                continue;
            }
            $interfaces = class_implements($class);
            if (empty($interfaces)) {
                continue;
            }
            $interfaces = array_flip($interfaces);
            if (!isset($interfaces[MappingRegistrationInterface::class])) {
                continue;
            }
            if ($definition->hasTag('mapper.mapping_registration')) {
                continue;
            }
            $definition->addTag('mapper.mapping_registration');
        }
    }
}