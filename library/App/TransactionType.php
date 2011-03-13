<?php

namespace App;

final class TransactionType
{
    const TRANSFER = 1;
    const DEPOSIT = 2;
    const WITHDRAWAL = 3;
    
    /**
     * Gets the string of an transaction type
     * 
     * @param int $transactionTypeId
     * @return string
     */
    public function getString($transactionTypeId)
    {
        switch ($transactionTypeId) {
            case 1:
                $result = 'transfer';
                break;
            
            case 2:
                $result = 'deposit';
                break;
            
            case 3:
                $result = 'withdrawal';
                break;
        }
        return $result;
    }
    
    /**
     * Gets a list of all account types with their stringsµ
     * 
     * @return array
     */
    public function getList()
    {
        $reflectionClass = new \ReflectionClass('\App\TransactionType');
        $array = $reflectionClass->getConstants();
        
        // Create array with strings
        $arrayWithStrings = array();
        foreach ($array as $value) {
            $arrayWithStrings[$value] = $this->getString($value); 
        }
        
        return $arrayWithStrings;
    }    
}
