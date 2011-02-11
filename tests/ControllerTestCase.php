<?php

class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected function setUp()
    {
        global $application;
        $application->bootstrap();
    }
}
