<?php


namespace Seacommerce\MapperBundle\Test;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

trait TestingTrait
{
    public function createSchema(EntityManagerInterface $em, bool $drop = true): void
    {
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if ($drop) {
            $schemaTool->dropSchema($metadata);
        }
        /** @noinspection PhpUnhandledExceptionInspection */
        $schemaTool->createSchema($metadata);
    }

//    public function loadFixtures(EntityManagerInterface $em, Fixture... $fixtures)
//    {
//        $loader = new Loader();
//        foreach ($fixtures as $fixture) {
//            $loader->addFixture($fixture);
//        }
//        $executor = new ORMExecutor($em, new ORMPurger($em));
//        $executor->execute($loader->getFixtures());
//    }
}