<?php

namespace App\Entity;

class PayeeTest extends \ModelTestCase
{
    public function testCanCreatePayee()
    {
        $this->assertInstanceOf('\App\Entity\Payee', new Payee());
    }
    
    public function testCanSavePayee()
    {
        $nameStub = 'foo';
        $addressStub = 'foo street 1';
        $phoneStub = '454878788787';
        $emailStub = 'foo@bar.com';
        
        $payee = new Payee();
        $payee->setId(30);
        $payee->setName($nameStub);
        $payee->setAddress($addressStub);
        $payee->setPhone($phoneStub);
        $payee->setEmail($emailStub);
        
        $this->_em->persist($payee);
        $this->_em->flush();
        
        $result = $this->_em->createQuery('SELECT p FROM \App\Entity\Payee p')
            ->getSingleResult();
        
        $this->assertEquals(1, $result->getId());
        $this->assertEquals($nameStub, $result->getName());
        $this->assertEquals($addressStub, $result->getAddress());
        $this->assertEquals($phoneStub, $result->getPhone());
        $this->assertEquals($emailStub, $result->getEmail());
    }
}
