<?php

/**
 * Account service
 */
class Application_Service_Account
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\AccountRepository
     */
    private $_repository;

    public function __construct()
    {
        $doctrineContainer = Zend_Registry::get('doctrine');
        $this->_entityManager = $doctrineContainer->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\Account'
        );
    }
    
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    public function fetchById($accountId)
    {
        return $this->_repository->find($accountId);
    }

    public function saveAccount($account, array $values)
    {
        $bankService = App\ServiceLocator::getBankService();
        $values['bank'] = $bankService->fetchById($values['bank']);
        
        $this->_repository->saveAccount($account, $values);
        $this->_entityManager->flush();
    }

    public function removeById($accountId)
    {       
        $this->_repository->removeAccount($accountId);
        $this->_entityManager->flush();
    }
}
