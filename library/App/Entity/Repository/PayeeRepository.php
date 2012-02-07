<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Payee;

class PayeeRepository extends EntityRepository
{
    /**
     * Saves a payee
     * 
     * @param Payee $payee
     * @param array $values 
     */
    public function savePayee(Payee $payee, array $values)
    {
        $payee->setName($values['name']);
        $payee->setAddress($values['address']);
        $payee->setPhone($values['phone']);
        $payee->setEmail($values['email']);

        $this->getEntityManager()->persist($payee);
        
        return $payee;
    }
    
    /**
     * Removes a payee
     * 
     * @param Payee $payee 
     */
    public function removePayee(Payee $payee)
    {
        
        $this->getEntityManager()->remove($payee);
    }
}
