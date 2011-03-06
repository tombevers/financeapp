<?php

namespace App\Entity;

class AccountTest extends \ModelTestCase
{
    public function testCanCreateAccount()
    {
        $this->assertInstanceOf('App\Entity\Account', new Account());
    }

    public function testCanSaveAccount()
    {
        $bankStub = new Bank();
        $bankStub->setName('foo Bank');
        $bankStub->setComment('');
        $this->_em->persist($bankStub);
        $this->_em->flush();

        $nameStub = 'foo';
        $numberStub = '546688897';
        $commentStub = 'comment';

        $account = new Account();
        $account->setId(30);
        $account->setName($nameStub);
        $account->setBank($bankStub);
        $account->setNumber($numberStub);
        $account->setcomment($commentStub);

        $this->_em->persist($account);
        $this->_em->flush();

        $result = $this->_em->createQuery('SELECT a FROM \App\Entity\Account a')
            ->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertEquals($nameStub, $result->getName());
        $this->assertEquals($bankStub, $result->getBank());
        $this->assertEquals($numberStub, $result->getNumber());
        $this->assertEquals($commentStub, $result->getComment());
    }
}
