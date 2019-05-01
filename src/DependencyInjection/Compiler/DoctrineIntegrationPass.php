<?php


namespace Seacommerce\MapperBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DoctrineIntegrationPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('doctrine.orm.proxy_namespace')) {
            $container->setParameter('mapper.doctrine.proxy_namespace', '%doctrine.orm.proxy_namespace%');
        } else {
            $container->setParameter('mapper.doctrine.proxy_namespace', 'Proxies');
        }

        if($container->hasDefinition('sc.mapper.default')) {
            $mapper = $container->getDefinition('sc.mapper.default');
            if ($container->hasDefinition('event_dispatcher')) {
                $mapper->addMethodCall('setEventDispatcher', [new Reference('event_dispatcher')]);
            }
        }
    }
}