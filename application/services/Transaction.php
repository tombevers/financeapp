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
     * @var Application_Service_TransactionType 
     */
    private $_typeService;

    /**
     * @var Application_Service_TransactionCategory
     */    
    private $_categoryService;

    /**
     * @var Application_Service_Account
     */    
    private $_accountService;
    
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
     * Sets the transaction type service
     * 
     * @param string $service
     */
    public function setTransactionTypeService($service)
    {
        $this->_typeService = $service;
    }

    /**
     * Sets the transaction category service
     * 
     * @param string $service 
     */
    public function setTransactionCategoryService($service)
    {
        $this->_categoryService = $service;
    }

    /**
     * Sets the account service
     * 
     * @param string $service 
     */    
    public function setAccountService($service)
    {
        $this->_accountService = $service;
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
        $values['type'] = $this->_typeService->fetchById($values['type']);
        $values['account'] = $this->_accountService->fetchById($values['account']);
        $values['category'] = $this->_categoryService->fetchById($values['category']);
        
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
