<?php

namespace App;

class ServiceLocator
{

// -- [ Services ] -------------------------------------------------------------

    /**
     * @return \Application_Service_Bank
     */
    public static function getBankService()
    {
        return new \Application_Service_Bank();
    }

    /**
     * @return \Application_Service_Account 
     */
    public static function getAccountService()
    {
        return new \Application_Service_Account();
    }
 
    /**
     * @return \Application_Service_AccountType
     */
    public static function getAccountTypeService()
    {
        return new \Application_Service_AccountType();
    }
    
    /**
     * @return \Application_Service_Payee
     */
    public static function getPayeeService()
    {
        return new \Application_Service_Payee();
    }
    
    public static function getTransactionService()
    {
        return new \Application_Service_Transaction();
    }
}
