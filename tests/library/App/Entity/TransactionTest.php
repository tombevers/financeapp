<?php

class TransactionTest extends ModelTestCase
{
    public function testCanCreateTransaction()
    {
        $this->assertInstanceOf(
            'App\Entity\Transaction',
            new App\Entity\Transaction
        );
    }

    public function testCanSaveTransaction()
    {
        $accountStub = new App\Entity\Account();
        $accountStub->setType(\App\AccountType::BANK);
        $accountStub->setName('accountName');
        $this->_em->persist($accountStub);
        
        $amountStub = '100';
        $typeStub = \App\TransactionType::TRANSFER;
        $dateStub = new \DateTime();
        $noteStub = 'note';

        $transaction = new App\Entity\Transaction();
        $transaction->setId(30);
        $transaction->setType($typeStub);
        $transaction->setAccount($accountStub);
        $transaction->setAmount($amountStub);
        $transaction->setDate($dateStub);
        $transaction->setNote($noteStub);
        
        $this->_em->persist($transaction);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT t FROM \App\Entity\Transaction t'
        )->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertEquals($typeStub, $result->getType());
        $this->assertEquals(
            $accountStub->getName(),
            $result->getAccount()->getName()
        );
        $this->assertEquals($amountStub, $result->getAmount());
        $this->assertEquals($dateStub, $result->getDate());
        $this->assertEquals($noteStub, $result->getNote());
    }
}
