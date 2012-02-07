<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Bank;

class BankRepository extends EntityRepository
{
    /**
     * Saves a bank
     * 
     * @param Bank $bank
     * @param array $values
     * @return Bank
     */
    public function saveBank(Bank $bank, array $values)
    {
        $bank->setName($values['name']);
        $bank->setAddress($values['address']);
        $bank->setWebsite($values['website']);
        $bank->setComment($values['comment']);

        $this->getEntityManager()->persist($bank);
        
        return $bank;
    }

    /**
     * Remove a bank
     * 
     * @param Bank $bank
     */
    public function removeBank(Bank $bank)
    {
        $this->getEntityManager()->remove($bank);
    }
}
