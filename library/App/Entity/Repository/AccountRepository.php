<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Account;

class AccountRepository extends EntityRepository
{
    /**
     * Saves an account
     * 
     * @param Account $account
     * @param array $values 
     */
    public function saveAccount(Account $account, array $values)
    {
        $account->setName($values['name']);
        $account->setNumber($values['number']);
        $account->setBank($values['bank']);
        $account->setComment($values['comment']);
        
//        $this->getEntityManager()->persist($account->getBank());
        $this->getEntityManager()->persist($account);
    }
    
    /**
     * Remove an account
     * @param int $accountId 
     */
    public function removeAccount($accountId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\Account', $accountId);

        $em->remove($proxy);
    }
}
