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
     */
    public function saveBank(Bank $bank, array $values)
    {
        $bank->setName($values['name']);
        $bank->setAddress($values['address']);
        $bank->setWebsite($values['website']);
        $bank->setComment($values['comment']);

        $this->getEntityManager()->persist($bank);
    }

    /**
     * Remove a bank
     * 
     * @param int $bankId 
     */
    public function removeBank($bankId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\Bank', $bankId);

        $em->remove($proxy);
    }
}
