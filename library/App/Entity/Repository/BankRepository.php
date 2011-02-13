<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Bank;

class BankRepository extends EntityRepository
{
    public function saveBank(Bank $bank, array $values)
    {
        $bank->setName($values['name']);
        $bank->setAddress($values['address']);
        $bank->setWebsite($values['website']);
        $bank->setComment($values['comment']);

        $this->getEntityManager()->persist($bank);
    }
}
