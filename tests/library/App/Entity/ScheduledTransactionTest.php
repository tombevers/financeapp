<?php

class ScheduledTransactionTest extends ModelTestCase
{
    public function testCanCreatePayee()
    {
        $this->assertInstanceOf('\App\Entity\ScheduledTransaction', new App\Entity\ScheduledTransaction());
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
        $nextDateStub = new \DateTime();
        $frequencyStub = 'one time';
        $continuousStub = FALSE;
        $numberStub = 100;
        $activeStub = TRUE;

        $scheduledTransaction = new App\Entity\ScheduledTransaction();
        $scheduledTransaction->setId(30);
        $scheduledTransaction->setType($typeStub);
        $scheduledTransaction->setAccount($accountStub);
        $scheduledTransaction->setAmount($amountStub);
        $scheduledTransaction->setNextDate($nextDateStub);
        $scheduledTransaction->setCategory($categoryStub);
        $scheduledTransaction->setFrequency($frequencyStub);
        $scheduledTransaction->setContinuous($continuousStub);
        $scheduledTransaction->setNumber($numberStub);
        $scheduledTransaction->setActive($activeStub);

        $this->_em->persist($scheduledTransaction);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT st FROM \App\Entity\ScheduledTransaction st'
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
        $this->assertEquals($nextDateStub, $result->getNextDate());
        $this->assertEquals(
            $categoryStub->getName(),
            $result->getCategory()->getName()
        );
        $this->assertEquals($frequencyStub, $result->getFrequency());
        $this->assertEquals($continuousStub, $result->isContinuous());
        $this->assertEquals($numberStub, $result->getNumber());
        $this->assertEquals($activeStub, $result->isActive());
    }
}
