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
    
    public function findGridData($firstResult, $maxResults, array $sorting, array $filters)
    {        
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('t._id AS id, t._date AS date, t._amount AS amount')
            ->from('App\Entity\Transaction', 't')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        if (!empty($sorting)) {
            foreach ($sorting as $sort) {
                $queryBuilder->orderBy('t.' . $sort['column'], $sort['order']);
            }
        }
        
        if (!empty($filters)) {
            $orx = $queryBuilder->expr()->orx();
            foreach ($filters as $filter) {
                $orx->add($queryBuilder->expr()->like(
                    't.' . $filter['column'],
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
