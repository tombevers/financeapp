<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Transaction;

class TransactionRepository extends EntityRepository
{
    public function findAllOrderByDate()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('t')
            ->from('App\Entity\Transaction', 't')
            ->orderBy('t._date');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    /**
     * Saves a transaction
     * 
     * @param Transaction $transaction
     * @param array $values 
     */
    public function saveTransaction(Transaction $transaction, array $values)
    {
        $transaction->setType($values['type']);
        $transaction->setAccount($values['account']);
        $transaction->setAmount($values['amount']);
        $transaction->setDate($values['date']);
        $transaction->setNote($values['note']);
        $transaction->setCategory($values['category']);

        $this->getEntityManager()->persist($transaction);
    }
    
    /**
     * Remove a transaction
     * @param int $transactionId 
     */
    public function removeTransaction($transactionId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\Transaction', $transactionId);

        $em->remove($proxy);
    }
}
