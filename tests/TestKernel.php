<?php

namespace Seacommerce\MapperBundle\Test;

use Seacommerce\MapperBundle\MapperBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class TestKernel extends AbstractTestKernel
{
    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        yield new MapperBundle();
        yield new FrameworkBundle();
    }

    /**
     * Loads the container configuration.
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            $loader->load(__DIR__ . '/services.yaml');
            $container->setParameter('kernel.secret', '%env(APP_SECRET)%');
            $container->loadFromExtension('framework', [
                'test' => true,
            ]);
        });
    }
}