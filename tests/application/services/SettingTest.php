<?php

class Application_Service_SettingTest extends AbstractManagerBase
{
    private $_currencies;
    private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_currencies = array(
            'EUR' => array('Euro', '€'),
            'GBP' => array('Pond Sterling', '£'),
            'USD' => array('United States Dollar', '$'),
            'YEN' => array('Yen', '¥'),
        );
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\SettingRepository',
            array(
                'findAll',
                'findOneBy',
                'saveSetting',
            ),
            array(),
            '',
            FALSE
        );        
    }
    
    public function testFetchAll()
    {
        $this->_repoMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Setting();
        $service->setSettingRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }
    
    public function testFetchByParameter()
    {
        $this->_repoMock->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Setting();
        $service->setSettingRepository($this->_repoMock);
        $this->assertTrue($service->fetchByParameter(1));
    }
    
    public function testTryToSaveEmptySettings()
    {
        $service = new Application_Service_Setting();
        $this->assertFalse($service->saveSettings(array()));
    }
    
    public function testSaveSettings()
    {
        $this->_repoMock->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(new \App\Entity\Setting('foo', 'bar')));
       $this->_repoMock->expects($this->once())
            ->method('saveSetting')
            ->will($this->returnValue(TRUE));
        
        $service = new Application_Service_Setting();
        $service->setSettingRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue($service->saveSettings(array(array('foo' => 'bar'))));
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
