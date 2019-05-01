<?php

namespace Seacommerce\MapperBundle\DependencyInjection;

use Seacommerce\Mapper\Compiler\CachedLoader;
use Seacommerce\Mapper\Compiler\CompilerInterface;
use Seacommerce\Mapper\Compiler\LoaderInterface;
use Seacommerce\Mapper\Compiler\NativeCompiler;
use Seacommerce\Mapper\Mapper;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\MapperBundle\CacheWarmer;
use Seacommerce\MapperBundle\DefaultMapperFactory;
use Seacommerce\MapperBundle\EventListener\DoctrineProxyEventSubscriber;
use Seacommerce\MapperBundle\MappingRegistrationInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BundleExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->setParameter('sc.mapper.compiler_cache_dir', '%kernel.cache_dir%/seacommerce/mapper/');

        // Compiler
        $container->setDefinition('sc.mapper.compiler.native', (new Definition(NativeCompiler::class)));
        $container->setAlias('sc.mapper.compiler.default', new Alias('sc.mapper.compiler.native'));
        $container->setAlias(CompilerInterface::class, new Alias('sc.mapper.compiler.default'));

        // Loader
        $container->setDefinition('sc.mapper.loader.cached', (new Definition(CachedLoader::class))
            ->setArgument('$compiler', new Reference('sc.mapper.compiler.native'))
            ->setArgument('$cacheFolder', '%sc.mapper.compiler_cache_dir%'))
            ->setPublic(true);
        $container->setAlias('sc.mapper.loader.default', new Alias('sc.mapper.loader.cached'));
        $container->setAlias(LoaderInterface::class, new Alias('sc.mapper.loader.default'));

        // Mapper factory
        $container->setDefinition('sc.mapper.mapper_factory.default', (new Definition(DefaultMapperFactory::class))
            ->setArgument('$loader', new Reference('sc.mapper.loader.cached'))
            ->setArgument('$logger', new Reference('logger'))
            ->setArgument('$registrations', new TaggedIteratorArgument('mapper.mapping_registration')));

        // Mapper
        $container->setDefinition('sc.mapper.default', (new Definition(Mapper::class))
            ->setFactory([new Reference('sc.mapper.mapper_factory.default'), 'create']))
            ->setPublic(true);

        $container->setAlias(MapperInterface::class, new Alias('sc.mapper.default'));


        // Cache warmer
        $container->setDefinition('sc.mapper.cache_warmer', (new Definition(CacheWarmer::class))
            ->setPublic(true)
            ->setArgument('$factory', new Reference('sc.mapper.mapper_factory.default'))
            ->addTag('kernel.cache_warmer', ['priority' => 0]));

        $container->registerForAutoconfiguration(MappingRegistrationInterface::class)
            ->addTag('mapper.mapping_registration');


        $bundles = $container->getParameter('kernel.bundles');

        // Doctrine integration
        if (array_key_exists('DoctrineBundle', $bundles)) {
            // Doctrine event subscriber
            $container->setDefinition('sc.mapper.doctrine.proxy_event_subscriber', (new Definition(DoctrineProxyEventSubscriber::class))
                ->addTag('kernel.event_subscriber')
                ->addMethodCall('setProxyNamespace', ['%mapper.doctrine.proxy_namespace%']));
        }
    }

    public function getAlias()
    {
        return 'sc.mapper';
    }
}