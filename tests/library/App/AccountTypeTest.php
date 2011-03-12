<?php

namespace App;

class AccountTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testAccountTypeEnums()
    {
        $this->assertEquals(AccountType::BANK, 1);
        $this->assertEquals(AccountType::CASH, 2);
        $this->assertEquals(AccountType::CREDITCARD, 3);
    }
    
    public function testAccountTypeBankString()
    {
        $accountType = new AccountType();
        $this->assertEquals(
            $accountType->getString(AccountType::BANK),
            'bank'
        );
    }
    
    public function testAccountTypeCashString()
    {
        $accountType = new AccountType();
        $this->assertEquals(
            $accountType->getString(AccountType::CASH),
            'cash'
        );
    }
    
    public function testAccountTypeCreditcardString()
    {
        $accountType = new AccountType();
        $this->assertEquals(
            $accountType->getString(AccountType::CREDITCARD),
            'creditCard'
        );
    }
    
    public function testGetList()
    {
        $accountType = new AccountType();
        $this->assertEquals(count($accountType->getList()), 3);
    }
}
