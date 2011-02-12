<?php

class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
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
}
