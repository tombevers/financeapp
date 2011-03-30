<?php

class testingConfigTest extends PHPUnit_Framework_TestCase
{
    protected $_config;
    
    public function setUp()
    {
        $this->_config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/application.ini',
            'testing'
        );
    }
    
    public function testObjectInstance()
    {
        $this->assertEquals(TRUE, is_object($this->_config));
    }
    
    public function testDefaultLayout()
    {
        $this->assertEquals(
            'wrapper',
            $this->_config->resources->layout->layout
        );
    }
    
    public function testErrorModes()
    {
        $this->assertEquals(
            1,
            $this->_config->phpSettings->display_startup_errors
        );
        $this->assertEquals(
            1,
            $this->_config->phpSettings->display_errors
        );
        $this->assertEquals(
            0,
            $this->_config->resources->frontController
            ->params->displayExceptions
        );
    }
}
