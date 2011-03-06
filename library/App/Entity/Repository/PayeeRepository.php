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
    }
    
    /**
     * Removes a payee
     * 
     * @param int $payeeId 
     */
    public function removePayee($payeeId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\Payee', $payeeId);

        $em->remove($proxy);
    }
}
