<?php

/**
 * Payee service
 */
class Application_Service_Payee
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\PayeeRepository
     */
    private $_repository;

    public function __construct()
    {
        $doctrineContainer = Zend_Registry::get('doctrine');
        $this->_entityManager = $doctrineContainer->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\Payee'
        );
    }

    /**
     * Fetch all payees
     *
     * @return array[\App\Entity\Payee]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetch a payee by id
     *
     * @param int $payeeId
     * @return \App\Entity\Payee
     */
    public function fetchById($payeeId)
    {
        return $this->_repository->find($payeeId);
    }

    /**
     * Saves a payee
     *
     * @param \App\Entity\Payee $payee
     * @param array $values
     */
    public function savePayee(\App\Entity\Payee $payee, array $values)
    {
        $this->_repository->savePayee($payee, $values);
        $this->_entityManager->flush();
    }

    /**
     * Removes a payee
     *
     * @param int $payeeId
     */
    public function removeById($payeeId)
    {
        $this->_repository->removePayee($payeeId);
        $this->_entityManager->flush();
    }
}
