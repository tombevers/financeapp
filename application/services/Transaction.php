<?php

/**
 * Transaction service
 */
class Application_Service_Transaction extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\TransactionRepository
     */
    private $_repository;
    
    /**
     * Sets the transaction repository
     * 
     * @param string $repository 
     */
    public function setTransactionRepository($repository)
    {
        $this->_repository = $this->getEntityManager()->getRepository($repository);
    }
    
    /**
     * Fetch all transactions
     *
     * @return array[\App\Entity\Transaction]
     */
    public function fetchAll()
    {
        try {
            return $this->_repository->findAllOrderByDate();
        } catch (\Doctrine\ORM\ORMException $exc) {
            return NULL;
        }
    }

    /**
     * Fetch a transaction by id
     *
     * @param int $transactionId
     * @return \App\Entity\Transaction
     */
    public function fetchById($transactionId)
    {
        return $this->_repository->find($transactionId);
    }

    /**
     * Saves a transaction
     *
     * @param \App\Entity\Transaction $transaction
     * @param array $values
     */
    public function saveTransaction(\App\Entity\Transaction $transaction,
        array $values)
    {
        $typeService = $this->get('service.transactiontype');
        $accountService = $this->get('service.account');
        $categoryService = $this->get('service.transactioncategory');
        
        $values['type'] = $typeService->fetchById($values['type']);
        $values['account'] = $accountService->fetchById($values['account']);
        $values['category'] = $categoryService->fetchById($values['category']);
        
        list($year, $month, $day) = explode('-', $values['date']);
        $date = new DateTime();
        $date->setDate($year, $month, $day);
        $values['date'] = $date;

        $this->_repository->saveTransaction($transaction, $values);
        $this->getEntityManager()->flush();
    }

    /**
     * Removes a transaction
     *
     * @param int $transactionId
     */
    public function removeById($transactionId)
    {
        $this->_repository->removeTransaction($transactionId);
        $this->getEntityManager()->flush();
    }
}
