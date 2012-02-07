<?php

class Application_Service_BankTest extends AbstractManagerBase
{
    private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\BankRepository',
            array(
                'find',
                'findAll',
                'removeBank',
                'saveBank'
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
        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }

    public function testFetchById()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        $this->assertTrue($service->fetchById(1));        
    }
    
    public function testSaveBank()
    {
        $values = array(
            'name' => 'foobar',
            'address' => 'foobar',
            'website' => 'foobar',
            'comment' => 'foobar',
        );
        
        $this->_repoMock->expects($this->once())
            ->method('saveBank')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue(
            $service->saveBank(new \App\Entity\Bank(), $values)
        ); 
        
    }
    
    public function testRemoveByNonExistingId()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(NULL));

        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertFalse($service->removeById(1));
    }
    
    public function testRemoveById()
    {
        $bank = new \App\Entity\Bank();
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue($bank));
        
        $this->_repoMock->expects($this->once())
            ->method('removeBank')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue($service->removeById(1));
    }
    
    public function testCreateOptions()
    {
        $bankStub = new App\Entity\Bank();
        $bankStub->setName('name');
        $bankStub->setId(1);
        
        $expected = array(
            1 => 'name'
        );
        
        $this->_repoMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(array($bankStub)));        
        
        $service = new Application_Service_Bank();
        $service->setBankRepository($this->_repoMock);
        
        $this->assertEquals($expected, $service->createOptions());
    }    
}
