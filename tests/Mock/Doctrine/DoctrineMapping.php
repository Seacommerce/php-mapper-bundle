<?php


namespace Seacommerce\MapperBundle\Test\Mock\Doctrine;

use Doctrine\Common\Collections\Collection;
use Seacommerce\Mapper\MapperInterface;
use Seacommerce\Mapper\Operation;
use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity\Invoice;
use Seacommerce\MapperBundle\Test\Mock\Doctrine\Model\InvoiceModel;

class DoctrineMapping implements MappingRegistrationInterface
{
    /**
     * @param Registry $registry
     * @throws \Exception
     */
    public function registerMappings(Registry $registry): void
    {
        $registry->add(Invoice::class, InvoiceModel::class)
            ->automap()
            ->forMember('customerId', Operation::fromProperty('customer'))
            ->forMember('items', Operation::fromProperty('items')->useConverter(function(?Collection $items) {
                return $items->toArray();
            }));
    }

    public function registerValueConverters(Registry $registry): void
    {

    }
}