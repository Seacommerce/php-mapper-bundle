<?php

namespace Seacommerce\MapperBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;

class DoctrineMappingRegistration implements MappingRegistrationInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function registerValueConverters(Registry $registry): void
    {
        $allMetaData = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($allMetaData as $classMetadata) {
//            $classMetadata->
        }
    }

    public function registerMappings(Registry $registry): void
    {
    }
}