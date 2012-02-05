<?php

class AbstractServiceTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $application;
        $application->bootstrap();

        /**
         * Fix for ZF-8193
         * http://framework.zend.com/issues/browse/ZF-8193
         * Zend_Controller_Action->getInvokeArg('bootstrap') doesn't work
         * under the unit testing environment.
         */
        $front = Zend_Controller_Front::getInstance();
        if($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $application->getBootstrap());
        }
    }

    public function testGetEntityManagerMethod()
    {
        $testClass = new testClass();
        $this->assertNull($testClass->getEntityManager());
    }

    public function testSetEntityManagerMethod()
    {
        $testClass = new testClass();
        $emMock = $this->getMock('\Doctrine\ORM\EntityManager', array(), array(), '', FALSE);
        $testClass->setEntityManager($emMock);
        $this->assertInstanceOf('\Doctrine\ORM\EntityManager', $testClass->getEntityManager());
    }
}

class testClass extends App\AbstractService
{

}
