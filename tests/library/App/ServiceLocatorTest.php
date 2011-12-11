<?php

class ServiceLocatorTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * @dataProvider serviceProvider
     */
    public function testGeters($expected, $getter)
    {
        $serviceLocator = new \App\ServiceLocator();
        
        $this->assertInstanceOf(
            $expected,
            $serviceLocator->$getter()
        );
    }

    public function serviceProvider()
    {
        return array(
            array(
                '\Application_Service_Bank',
                'getBankService'
            ),
            array(
                '\Application_Service_Account',
                'getAccountService'
            ),
            array(
                '\Application_Service_AccountType',
                'getAccountTypeService'),
            array(
                '\Application_Service_Payee',
                'getPayeeService'),
            array(
                '\Application_Service_Transaction',
                'getTransactionService'),
            array(
                '\Application_Service_TransactionType',
                'getTransactionTypeService'
            ),
            array(
                '\Application_Service_TransactionCategory',
                'getTransactionCategoryService'
            ),
            array(
                '\Application_Service_ScheduledTransaction',
                'getScheduledTransactionService'
            ),
            array(
                '\Application_Service_Setting',
                'getSettingService'
            )
        );
    }
    
}
