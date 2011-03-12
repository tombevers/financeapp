<?php

namespace App;

final class AccountType
{
    const BANK = 1;
    const CASH = 2;
    const CREDITCARD = 3;
    
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
}
