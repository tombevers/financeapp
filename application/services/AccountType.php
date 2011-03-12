<?php

/**
 * Account type service
 */
class Application_Service_AccountType
{
    /**
     * Fetches all available account types
     * 
     * @return array
     */
    public function fetchAll()
    {
        $accountTypes = new \App\AccountType();
        
        return $accountTypes->getList();
    }
}
