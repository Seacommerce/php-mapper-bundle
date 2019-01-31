<?php

namespace Seacommerce\Mapper\Bundle;

use Seacommerce\Mapper\Bundle\DependencyInjection\BundleExtension;
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
    }
}