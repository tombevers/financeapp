<?php

class TransactionTest extends ModelTestCase
{
    public function testCanCreateTransaction()
    {
        $this->assertInstanceOf(
            'App\Entity\Transaction',
            new App\Entity\Transaction()
        );
    }

    public function testCanSaveTransaction()
    {
        $accountTypeStub = new \App\Entity\AccountType();
        $accountTypeStub->setTag('fooTag');
        $this->_em->persist($accountTypeStub);

        $accountStub = new App\Entity\Account();
        $accountStub->setType($accountTypeStub);
        $accountStub->setName('accountName');
        $this->_em->persist($accountStub);

        $typeStub = new \App\Entity\TransactionType();
        $typeStub->setTag('fooType');
        $this->_em->persist($typeStub);
        
        $categoryStub = new \App\Entity\TransactionCategory();
        $categoryStub->setName('fooCat');
        $this->_em->persist($categoryStub);

        $amountStub = '100';
        $dateStub = new \DateTime();
        $noteStub = 'note';

        $transaction = new App\Entity\Transaction();
        $transaction->setId(30);
        $transaction->setType($typeStub);
        $transaction->setAccount($accountStub);
        $transaction->setAmount($amountStub);
        $transaction->setDate($dateStub);
        $transaction->setNote($noteStub);
        $transaction->setCategory($categoryStub);

        $this->_em->persist($transaction);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT t FROM \App\Entity\Transaction t'
        )->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertEquals(
            $typeStub->getTag(),
            $result->getType()->getTag()
        );
        $this->assertEquals(
            $accountStub->getName(),
            $result->getAccount()->getName()
        );
        $this->assertEquals($amountStub, $result->getAmount());
        $this->assertEquals($dateStub, $result->getDate());
        $this->assertEquals($noteStub, $result->getNote());
        $this->assertEquals(
            $categoryStub->getName(),
            $result->getCategory()->getName()
        );
    }
}
