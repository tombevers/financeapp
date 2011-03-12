<?php

class AccountTest extends ModelTestCase
{
    public function testCanCreateAccount()
    {
        $this->assertInstanceOf('App\Entity\Account', new App\Entity\Account());
    }

    public function testCanSaveAccount()
    {
        $bankStub = new App\Entity\Bank();
        $bankStub->setName('foo Bank');
        $this->_em->persist($bankStub);

        $nameStub = 'foo';
        $numberStub = '546688897';
        $commentStub = 'comment';
        $typeStub = App\AccountType::BANK;

        $account = new App\Entity\Account();
        $account->setId(30);
        $account->setType($typeStub);
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
        $this->assertEquals($typeStub, $result->getType());
        $this->assertEquals(
            $bankStub->getName(),
            $result->getBank()->getName()
        );
        $this->assertEquals($numberStub, $result->getNumber());
        $this->assertEquals($commentStub, $result->getComment());
    }
}
