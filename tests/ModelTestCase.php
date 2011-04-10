<?php

class ModelTestCase extends PHPUnit_Framework_TestCase
{
    protected $_container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    protected function setUp()
    {
        global $application;
        $application->bootstrap();

        $this->_container = $application->getBootstrap()->getContainer();
        $this->_em = $this->_container->get('doctrine.entitymanager');

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $tool->dropDatabase();
        $tool->createSchema($this->_em->getMetadataFactory()->getAllMetadata());
    }

    protected function tearDown()
    {
        $this->_em->getConnection()->close();
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $tool->dropDatabase();
    }
}
