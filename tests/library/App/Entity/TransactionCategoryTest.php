<?php

class TransactionCategoryTest extends ModelTestCase
{
    public function testCanCreateTransactionCategory()
    {
        $this->assertInstanceOf(
            'App\Entity\TransactionCategory',
            new App\Entity\TransactionCategory()
        );
    }

    public function testCanSaveTransactionCategory()
    {
        $nameStub = 'foobar';

        $transactionCategory = new App\Entity\TransactionCategory();
        $transactionCategory->setId(30);
        $transactionCategory->setParent(NULL);
        $transactionCategory->setName($nameStub);

        $this->_em->persist($transactionCategory);
        $this->_em->flush();

        $result = $this->_em->createQuery(
            'SELECT tc FROM \App\Entity\TransactionCategory tc'
        )->getSingleResult();

        $this->assertEquals(1, $result->getId());
        $this->assertNull($result->getParent());
        $this->assertEquals($nameStub, $result->getName());
        $this->assertInstanceOf('\Doctrine\ORM\PersistentCollection', $result->getChildren());
    }
}
