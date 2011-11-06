<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\ScheduledTransaction;

class ScheduledTransactionRepository extends EntityRepository
{
    public function findAllOrderByNextDate()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('st')
                ->from('App\Entity\ScheduledTransaction', 'st')
                ->orderBy('st._nextDate');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    /**
     * Saves a scheduled transaction
     * 
     * @param ScheduledTransaction $transaction
     * @param array $values 
     */
    public function saveScheduledTransaction(ScheduledTransaction $transaction, array $values)
    {
        $transaction->setType($values['type']);
        $transaction->setAccount($values['account']);
        $transaction->setCategory($values['category']);
        $transaction->setAmount($values['amount']);
        $transaction->setnextDate($values['nextDate']);
        $transaction->setFrequency($values['frequency']);
        $transaction->setContinuous($values['continuous']);
        $transaction->setNumber($values['number']);
        $transaction->setAutomatically($values['automatically']);
        
        $this->getEntityManager()->persist($transaction);
    }
    
    /**
     * Remove a scheduled transaction
     * @param int $transactionId 
     */
    public function removeScheduledTransaction($transactionId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\ScheduledTransaction', $transactionId);

        $em->remove($proxy);
    }
}
