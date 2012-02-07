<?php

class Application_Service_PayeeTest extends AbstractManagerBase
{
    private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\PayeeRepository',
            array(
                'find',
                'findAll',
                'savePayee',
                'removePayee'
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
        $service = new Application_Service_Payee();
        $service->setPayeeRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }

    public function testFetchById()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Payee();
        $service->setPayeeRepository($this->_repoMock);
        $this->assertTrue($service->fetchById(1));        
    }
    
    public function testSavePayee()
    {
        $values = array(
            'name' => 'foobar',
            'address' => 'foobar',
            'website' => 'foobar',
            'comment' => 'foobar',
        );
        
        $this->_repoMock->expects($this->once())
            ->method('savePayee')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Payee();
        $service->setPayeeRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue(
            $service->savePayee(new \App\Entity\Payee(), $values)
        ); 
        
    }
    
    public function testRemoveByNonExistingId()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(NULL));

        $service = new Application_Service_Payee();
        $service->setPayeeRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertFalse($service->removeById(1));
    }
    
    public function testRemoveById()
    {
        $payee = new \App\Entity\Payee();
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue($payee));
        
        $this->_repoMock->expects($this->once())
            ->method('removePayee')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_Payee();
        $service->setPayeeRepository($this->_repoMock);
        $service->setEntityManager($this->getEmMock());
        $this->assertTrue($service->removeById(1));
    }
}
