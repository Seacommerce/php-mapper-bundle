<?php

namespace Seacommerce\MapperBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Seacommerce\Mapper\Registry;
use Seacommerce\MapperBundle\MappingRegistrationInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Type;

class DoctrineMappingRegistration implements MappingRegistrationInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PropertyInfoExtractor
     */
    private $propertyInfoExtractor;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();

        $listExtractors = [$reflectionExtractor];
        $typeExtractors = [$phpDocExtractor, $reflectionExtractor];
        $descriptionExtractors = [$phpDocExtractor];
        $accessExtractors = [$reflectionExtractor];
        $propertyInitializableExtractors = [$reflectionExtractor];
        $this->propertyInfoExtractor = new PropertyInfoExtractor($listExtractors, $typeExtractors, $descriptionExtractors, $accessExtractors, $propertyInitializableExtractors);
    }

    public function registerValueConverters(Registry $registry): void
    {
        // Collection -> array
        // Entity -> id
        $allMetaData = $this->em->getMetadataFactory()->getAllMetadata();

        foreach ($allMetaData as $classMetadata) {
            $associations = $classMetadata->getAssociationNames();
            if (!$associations) {
                continue;
            }
            foreach ($associations as $association) {
                if ($classMetadata->isSingleValuedAssociation($association)) {
                    /** @var Type[] $types */
                    $types = $this->propertyInfoExtractor->getTypes($classMetadata->getName(), $association);
                    if (!$types || count($types) !== 1) {
                        continue;
                    }
                    /** @var Type $type */
                    $type = array_shift($types);
                    if ($type->getClassName() === null) {
                        continue;
                    }
                    $assocMeta = $this->em->getMetadataFactory()->getMetadataFor($type->getClassName());
                    $idFieldNames = $assocMeta->getIdentifierFieldNames();
                    if (!$idFieldNames || count($idFieldNames) !== 1) {
                        continue;
                    }
                    $idFieldName = array_shift($idFieldNames);
                    $idTypes = $this->propertyInfoExtractor->getTypes($assocMeta->getName(), $idFieldName);
                    if (!$idTypes || count($idTypes) !== 1) {
                        continue;
                    }
                    /** @var Type $idType */
                    $idType = array_shift($types);

//                    $registry->registerValueConverter($type->getClassName(), $idType, )
                }
            }
        }
    }

    public function registerMappings(Registry $registry): void
    {
    }
}