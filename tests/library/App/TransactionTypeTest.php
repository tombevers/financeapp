<?php

namespace App;

class TransactionTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testTransactionTypeEnums()
    {
        $this->assertEquals(TransactionType::TRANSFER, 1);
        $this->assertEquals(TransactionType::DEPOSIT, 2);
        $this->assertEquals(TransactionType::WITHDRAWAL, 3);
    }
    
    public function testTransactionTypeBankString()
    {
        $transactionType = new TransactionType();
        $this->assertEquals(
            $transactionType->getString(TransactionType::TRANSFER),
            'transfer'
        );
    }
    
    public function testTransactionTypeCashString()
    {
        $transactionType = new TransactionType();
        $this->assertEquals(
            $transactionType->getString(TransactionType::DEPOSIT),
            'deposit'
        );
    }
    
    public function testTransactionTypeWithdrawalString()
    {
        $transactionType = new TransactionType();
        $this->assertEquals(
            $transactionType->getString(TransactionType::WITHDRAWAL),
            'withdrawal'
        );
    }
    
    public function testGetList()
    {
        $transactionType = new TransactionType();
        $this->assertEquals(count($transactionType->getList()), 3);
    }
}
