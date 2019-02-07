<?php

namespace Seacommerce\MapperBundle;

use Seacommerce\MapperBundle\DependencyInjection\BundleExtension;
use Seacommerce\MapperBundle\DependencyInjection\Compiler\TagRegistrationsPass;
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
        $container->registerForAutoconfiguration(MappingRegistrationInterface::class)
            ->addTag('mapper.mapping_registration');
    }
}