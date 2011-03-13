<?php

/**
 * Transaction type service
 */
class Application_Service_TransactionType
{
    /**
     * Fetches all available transaction types
     * 
     * @return array
     */
    public function fetchAll()
    {
        $transactionTypes = new \App\TransactionType();
        
        return $transactionTypes->getList();
    }
}
