<?php

namespace Seacommerce\MapperBundle\Test;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
use Doctrine\Common\Annotations\AnnotationReader;
use Seacommerce\MapperBundle\MapperBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    /** @var bool */
    private $doctrineEnabled = false;

    public function enableDoctrineBundle()
    {
        $this->doctrineEnabled = true;
    }

    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        yield new MapperBundle();
        yield new MonologBundle();
    }

    /**
     * Loads the container configuration.
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            $loader->load(__DIR__ . '/services.yaml');

            if ($this->doctrineEnabled) {
                $container->setDefinition('annotation_reader', new Definition(AnnotationReader::class));
                $container->setDefinition('my.platform', new Definition('Doctrine\DBAL\Platforms\MySqlPlatform'))->setPublic(true);

                $container->registerExtension(new DoctrineExtension());
                $container->loadFromExtension('doctrine', [
                    'dbal' => [
                        'connections' => [
                            'default' => [
                                'driver' => 'pdo_mysql',
                                'charset' => 'UTF8',
                                'platform-service' => 'my.platform',
                            ],
                        ],
                        'default_connection' => 'default',
                    ],
                    'orm' => [
                        'default_entity_manager' => 'default',
                        'entity_managers' => [
                            'default' => [
                                'mappings' => [
                                    'Test' => [
                                        'type' => 'annotation',
                                        'dir' => __DIR__ . '/Mock/Doctrine/Entity',
                                        'prefix' => 'Seacommerce\MapperBundle\Test\Mock\Doctrine',
                                    ],
                                ],
                            ],
                        ],
                    ]
                ]);
            }
            $container->addCompilerPass(new TestCaseAllPublicCompilerPass());
            $container->addObjectResource($this);
        });
    }
}

class TestCaseAllPublicCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            $definition->setPublic(true);
        }
        foreach ($container->getAliases() as $id => $alias) {
            $alias->setPublic(true);
        }
    }
}