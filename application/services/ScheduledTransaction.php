<?php

/**
 * Scheduled Transaction service
 */
class Application_Service_ScheduledTransaction extends App\AbstractService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\ScheduledTransaction
     */
    private $_repository;

    public function __construct()
    {
        $this->_entityManager = $this->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\ScheduledTransaction'
        );
    }

    /**
     * Fetch all transactions
     *
     * @return array[\App\Entity\ScheduledTransaction]
     */
    public function fetchAll()
    {
        try {
            return $this->_repository->findAllOrderByNextDate();
        } catch (\Doctrine\ORM\ORMException $exc) {
            throw new Exception($exc);
            return NULL;
        }
    }

    /**
     * Fetch a transaction by id
     *
     * @param int $transactionId
     * @return \App\Entity\ScheduledTransaction
     */
    public function fetchById($transactionId)
    {
        return $this->_repository->find($transactionId);
    }
    
    /**
     * Saves a scheduled transaction
     *
     * @param \App\Entity\ScheduledTransaction $transaction
     * @param array $values
     */
    public function saveScheduledTransaction(\App\Entity\ScheduledTransaction $transaction,
        array $values)
    {
        $typeService = App\ServiceLocator::getTransactionTypeService();
        $values['type'] = $typeService->fetchById($values['type']);
        $accountService = App\ServiceLocator::getAccountService();
        $values['account'] = $accountService->fetchById($values['account']);
        $categoryService = App\ServiceLocator::getTransactionCategoryService();
        $values['category'] = $categoryService->fetchById($values['category']);
        
        list($year, $month, $day) = explode('-', $values['nextDate']);
        $nextDate = new DateTime();
        $nextDate->setDate($year, $month, $day);
        $values['nextDate'] = $nextDate;

        $this->_repository->saveScheduledTransaction($transaction, $values);
        $this->_entityManager->flush();
    }

    /**
     * Removes a scheduled transaction
     *
     * @param int $transactionId
     */
    public function removeById($transactionId)
    {
        $this->_repository->removeScheduledTransaction($transactionId);
        $this->_entityManager->flush();
    }
}
