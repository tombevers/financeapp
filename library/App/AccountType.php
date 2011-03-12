<?php

namespace App;

final class AccountType
{
    const BANK = 1;
    const CASH = 2;
    const CREDITCARD = 3;
    
    /**
     * Gets the string of an account type
     * 
     * @param int $accountTypeId
     * @return string
     */
    public function getString($accountTypeId)
    {
        switch ($accountTypeId) {
            case 1:
                $result = 'bank';
                break;
            
            case 2:
                $result = 'cash';
                break;
            
            case 3:
                $result = 'creditCard';
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
        $reflectionClass = new \ReflectionClass('\App\AccountType');
        $array = $reflectionClass->getConstants();
        
        // Create array with strings
        $arrayWithStrings = array();
        foreach ($array as $value) {
            $arrayWithStrings[$value] = $this->getString($value); 
        }
        
        return $arrayWithStrings;
    }
}
