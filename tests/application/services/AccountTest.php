<?php

class Application_Service_AccountTest extends AbstractManagerBase
{
    private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\AccountRepository',
            array(
                'findAll',
                'find',
                'removeAccount',
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
        $service = new Application_Service_Account();
        $service->setAccountRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }

    public function testFetchById()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Account();
        $service->setAccountRepository($this->_repoMock);
        $this->assertTrue($service->fetchById(1));        
    }
    
    public function testRemoveByNonExistingId()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(NULL));

        $service = new Application_Service_Account();
        $service->setAccountRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertFalse($service->removeById(1));
    }
    
    public function testRemoveById()
    {
        $account = new \App\Entity\Account();
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue($account));
        
        $this->_repoMock->expects($this->once())
            ->method('removeAccount')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Account();
        $service->setAccountRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue($service->removeById(1));
    }    
    
    public function testCreateOptions()
    {
        $accountStub = new App\Entity\Account();
        $accountStub->setName('name');
        $accountStub->setId(1);
        
        $expected = array(
            1 => 'name'
        );
        
        $this->_repoMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(array($accountStub)));        
        
        $service = new Application_Service_Account();
        $service->setAccountRepository($this->_repoMock);
        
        $this->assertEquals($expected, $service->createOptions());
    }    
}