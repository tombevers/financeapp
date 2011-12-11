<?php

class Application_Service_SettingTest extends PHPUnit_Framework_TestCase
{
    private $_currencies;
    
    public function setUp()
    {
        parent::setUp();
        global $application;
        $application->bootstrap();

        Zend_Session::$_unitTestEnabled = true;

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
        
        $this->_currencies = array(
            'EUR' => array('Euro', '€'),
            'GBP' => array('Pond Sterling', '£'),
            'USD' => array('United States Dollar', '$'),
            'YEN' => array('Yen', '¥'),
        );
    }
    
    public function testCreateCurrencyOptions()
    {
        $expected = array();
        foreach ($this->_currencies as $iso => $value) {
            $expected[$iso] = $value[0];
        }
        
        $service = new Application_Service_Setting();
        $this->assertEquals($expected, $service->createCurrencyOptions());
    }
    
    /**
     * @dataProvider isoCurrencyProvider
     */
    public function testGetCurrencySymbol($iso, $expected)
    {
        $service = new Application_Service_Setting();
        $this->assertEquals($expected, $service->getCurrenySymbol($iso));
    }
    
    public function isoCurrencyProvider()
    {
        return array(
            array('EUR', '€'),
            array('GBP', '£'),
            array('USD', '$'),
            array('YEN', '¥'),
            array('HULU', NULL),
        );
    }
}
