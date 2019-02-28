<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\MapperBundle\DependencyInjection\BundleExtension;
use Seacommerce\MapperBundle\DependencyInjection\Compiler\DoctrineIntegrationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MapperBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new BundleExtension();
    }

    function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DoctrineIntegrationPass());
        $container->registerForAutoconfiguration(MappingRegistrationInterface::class)
            ->addTag('mapper.mapping_registration');
    }
}