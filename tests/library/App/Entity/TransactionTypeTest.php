<?php

class TransactionTypeTest extends ModelTestCase
{
    public function testCanCreateTransactionType()
    {
        $this->assertInstanceOf(
            'App\Entity\TransactionType',
            new App\Entity\TransactionType()
        );
    }

    public function testCanSaveTransaction()
    {
        $tagStub = 'fooTag';

        $transactionType = new App\Entity\TransactionType();
        $transactionType->setId(30);
        $transactionType->setTag($tagStub);

        $this->_em->persist($transactionType);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT tt FROM \App\Entity\TransactionType tt'
        )->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertEquals($tagStub, $result->getTag());
    }
}
