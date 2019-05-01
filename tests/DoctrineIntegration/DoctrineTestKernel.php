<?php

namespace Seacommerce\MapperBundle\Test\DoctrineIntegration;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Seacommerce\MapperBundle\MapperBundle;
use Seacommerce\MapperBundle\Test\AbstractTestKernel;
use Seacommerce\MapperBundle\Test\DoctrineIntegration\Mapping\DoctrineMapping;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class DoctrineTestKernel extends AbstractTestKernel
{
    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        yield new FrameworkBundle();
        yield new MapperBundle();
        yield new DoctrineBundle();
    }

    /**
     * Loads the container configuration.
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {

            $container->setDefinition(DoctrineMapping::class, new Definition(DoctrineMapping::class))
                ->setPublic(true)
                ->setAutoconfigured(true);

            $container->setParameter('kernel.secret', '%env(APP_SECRET)%');
            $container->loadFromExtension('framework', [
                'test' => true,
            ]);
            $container->loadFromExtension('doctrine', [
                'dbal' => [
                    'driver' => 'pdo_sqlite',
                    'charset' => 'UTF8',
                    'path' => '%kernel.cache_dir%/test.sqlite'
                ],
                'orm' => [
                    'proxy_namespace' => 'CustomProxies',
                    'auto_generate_proxy_classes' => true,
                    'auto_mapping' => true,
                    'mappings' => [
                        'MapperBundleTest' => [
                            'dir' => __DIR__ . '/Entity',
                            'type' => 'annotation',
                            'prefix' => 'Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity',
                        ],
                    ],
                ],
            ]);
        });
    }
}