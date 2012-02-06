<?php

class Application_Service_AccountTypeTest extends AbstractManagerBase
{
    private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\AccountTypeRepository',
            array(
                'findAll',
                'find',
                'findBy',
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
        $service = new Application_Service_AccountType();
        $service->setAccountTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }

    public function testFetchById()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_AccountType();
        $service->setAccountTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchById(1));        
    }
    
    public function testFetchByTag()
    {
        $this->_repoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_AccountType();
        $service->setAccountTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchByTag('foobar'));        
    }    
    
    public function testCreateOptions()
    {
        $accountTypeStub = new App\Entity\AccountType();
        $accountTypeStub->setTag('foobar');
        $accountTypeStub->setId(1);
        
        $expected = array(
            1 => 'foobar'
        );
        
        $this->_repoMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(array($accountTypeStub)));        
        
        $service = new Application_Service_AccountType();
        $service->setAccountTypeRepository($this->_repoMock);
        
        $this->assertEquals($expected, $service->createOptions());
    }    
}