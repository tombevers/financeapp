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
    
    public function findPending(\DateTime $nextDate)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('st')
            ->from('App\Entity\ScheduledTransaction', 'st')
            ->where('st._nextDate <= ?1')
            ->andWhere('st._active = 1')
            ->setParameter(1, $nextDate, \Doctrine\DBAL\Types\Type::DATETIME);
        
        return $queryBuilder->getQuery()->getResult();        
    }
    
    public function findGridData($firstResult, $maxResults, array $sorting, array $filters)
    {        
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('st._id AS id, st._nextDate AS nextDate, st._frequency AS frequency, t._tag AS type, c._name AS category, st._amount AS amount, st._active AS active')
            ->from('App\Entity\ScheduledTransaction', 'st')
            ->join('st._type', 't')
            ->join('st._category', 'c')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        if (!empty($sorting)) {
            foreach ($sorting as $sort) {
                $queryBuilder->orderBy($sort['column'], $sort['order']);
            }
        }
        
        if (!empty($filters)) {
            $orx = $queryBuilder->expr()->orx();
            foreach ($filters as $filter) {
                $orx->add($queryBuilder->expr()->like(
                    $filter['column'],
                    $queryBuilder->expr()->literal('%' . $filter['filter'] . '%')
                    )
                );
            }
            $queryBuilder->where($orx);
        }
        
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($queryBuilder);
        $count = $paginator->count();
        $result = $paginator->getQuery()->getResult();
        
        return array($count, $result);
    }    
    
    /**
     * Saves a scheduled transaction
     * 
     * @param ScheduledTransaction $transaction
     * @param array $values
     * @return ScheduledTransaction 
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
        $transaction->setActive($values['active']);
        
        $this->getEntityManager()->persist($transaction);
        
        return $transaction;
    }
    
    /**
     * Updates the nextDate field
     * 
     * @param ScheduledTransaction $transaction
     * @param \DateTime $nextDate
     * @return ScheduledTransaction
     */
    public function updateNextDate(ScheduledTransaction $transaction, \DateTime $nextDate)
    {
        $transaction->setNextDate($nextDate);
        
        $this->getEntityManager()->persist($transaction);
        
        return $transaction;
    }

    /**
     * Updates the active field
     * 
     * @param ScheduledTransaction $transaction
     * @param boolean $active
     * @return ScheduledTransaction
     */
    public function updateActive(ScheduledTransaction $transaction, $active)
    {
        $transaction->setActive($active);
        
        $this->getEntityManager()->persist($transaction);
        
        return $transaction;
    }

    /**
     * Updates the number field
     * 
     * @param ScheduledTransaction $transaction
     * @param int $number
     * @return ScheduledTransaction
     */
    public function updateNumber(ScheduledTransaction $transaction, $number)
    {
        $transaction->setNumber($number);
        
        $this->getEntityManager()->persist($transaction);
        
        return $transaction;
    }    
    
    /**
     * Remove a scheduled transaction
     * @param int $transactionId 
     */
    public function removeScheduledTransaction(ScheduledTransaction $transaction)
    {
        $this->getEntityManager()->remove($entity);
    }
}
