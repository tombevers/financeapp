<?php

class ModelTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected $_doctrineContainer;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    protected function setUp()
    {
        global $application;
        $application->bootstrap();
        $this->_doctrineContainer = Zend_Registry::get('doctrine');
        $this->_em = $this->_doctrineContainer->getEntityManager();

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $tool->dropDatabase();
        $tool->createSchema($this->_em->getMetadataFactory()->getAllMetadata());
    }

    protected function tearDown()
    {
        $this->_doctrineContainer->getConnection()->close();
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
        $tool->dropDatabase();
    }
}
