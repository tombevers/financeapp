<?php

class AccountTypeTest extends ModelTestCase
{
    public function testCanCreateAccount()
    {
        $this->assertInstanceOf(
            'App\Entity\AccountType',
            new App\Entity\AccountType()
        );
    }

    public function testCanSaveAccountType()
    {
        $tagStub = 'fooTag';

        $accountType = new App\Entity\AccountType();
        $accountType->setId(30);
        $accountType->setTag($tagStub);

        $this->_em->persist($accountType);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT at FROM \App\Entity\AccountType at'
        )->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertEquals($tagStub, $result->getTag());
    }
}
