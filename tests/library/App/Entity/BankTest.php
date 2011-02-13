<?php

namespace App\Entity;

class BankTest extends \ModelTestCase
{
    /**
     * @var \App\Entity\Repository\BankRepository
     */
    protected $_bankRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->_bankRepository = $this->_em->getRepository('\App\Entity\Bank');
    }

    public function testCanCreateBank()
    {
        $this->assertInstanceOf('App\Entity\Bank', new Bank());
    }

    public function testCanSaveBank()
    {
        // Save bank
        $nameStub = 'foo';
        $addressStub = 'foo street 1';
        $websiteStub = 'http://foo.com';
        $commentStub = 'foo bar';
        
        $bank = new Bank();
        $bank->setId(30);
        $bank->setName($nameStub);
        $bank->setAddress($addressStub);
        $bank->setWebsite($websiteStub);
        $bank->setComment($commentStub);

        $this->_em->persist($bank);
        $this->_em->flush();

        $result = $this->_em->createQuery('SELECT b FROM \App\Entity\Bank b')->getSingleResult();
        
        $this->assertEquals(1, $result->getId());
        $this->assertEquals($nameStub, $result->getName());
        $this->assertEquals($addressStub, $result->getAddress());
        $this->assertEquals($websiteStub, $result->getWebsite());
        $this->assertEquals($commentStub, $result->getComment());
    }
}
