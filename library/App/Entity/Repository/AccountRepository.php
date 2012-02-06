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
        $account->setType($values['type']);
        $account->setName($values['name']);
        $account->setNumber($values['number']);
        $account->setBank($values['bank']);
        $account->setComment($values['comment']);

        $this->getEntityManager()->persist($account);
    }
    
    /**
     * Remove an account
     * @param int $accountId 
     */
    public function removeAccount(Account $account)
    {
        $this->getEntityManager()->remove($account);
    }
}
