<?php

class Application_Service_TransactionTypeTest extends AbstractManagerBase
{
 private $_repoMock;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_repoMock = $this->getMock(
            'App\Entity\Repository\TransactionTypeRepository',
            array(
                'find',
                'findAll',
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
        $service = new Application_Service_TransactionType();
        $service->setTransactionTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchAll());        
    }

    public function testFetchById()
    {
        $this->_repoMock->expects($this->once())
            ->method('find')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_TransactionType();
        $service->setTransactionTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchById(1));        
    }
    
    public function testFetchByTag()
    {
        $this->_repoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(TRUE));
        $service = new Application_Service_TransactionType();
        $service->setTransactionTypeRepository($this->_repoMock);
        $this->assertTrue($service->fetchByTag('foobar'));  
    }    
    
    public function testCreateOptions()
    {
        $transactionTypeStub = new App\Entity\TransactionType();
        $transactionTypeStub->setTag('fooBar');
        $transactionTypeStub->setId(1);
        
        $expected = array(
            1 => 'fooBar'
        );
        
        $this->_repoMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(array($transactionTypeStub))); 
        
        $service = new Application_Service_TransactionType();
        $service->setTransactionTypeRepository($this->_repoMock);
        
        $this->assertEquals($expected, $service->createOptions());
    }        
}
