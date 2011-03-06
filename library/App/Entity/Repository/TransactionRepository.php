<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\Transaction;

class TransactionRepository extends EntityRepository
{
    /**
     * Saves a transaction
     * 
     * @param Transaction $transaction
     * @param array $values 
     */
    public function saveTransaction(Transaction $transaction, array $values)
    {
        $transaction->setAccount($values['account']);
        $transaction->setAmount($values['amount']);
        $transaction->setDate($values['date']);
        $transaction->setNote($values['note']);

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
