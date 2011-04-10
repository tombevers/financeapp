<?php

/**
 * Transaction service
 */
class Application_Service_Transaction extends App\AbstractService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\TransactionRepository
     */
    private $_repository;

    public function __construct()
    {
        $this->_entityManager = $this->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\Transaction'
        );
    }

    /**
     * Fetch all transactions
     *
     * @return array[\App\Entity\Transaction]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
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
        $typeService = App\ServiceLocator::getTransactionTypeService();
        $values['type'] = $typeService->fetchById($values['type']);
        $accountService = App\ServiceLocator::getAccountService();
        $values['account'] = $accountService->fetchById($values['account']);

        list($year, $month, $day) = explode('-', $values['date']);
        $date = new DateTime();
        $date->setDate($year, $month, $day);
        $values['date'] = $date;

        $this->_repository->saveTransaction($transaction, $values);
        $this->_entityManager->flush();
    }

    /**
     * Removes a transaction
     *
     * @param int $transactionId
     */
    public function removeById($transactionId)
    {
        $this->_repository->removeTransaction($transactionId);
        $this->_entityManager->flush();
    }
}
