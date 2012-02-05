<?php

/**
 * Account service
 */
class Application_Service_Account extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\AccountRepository
     */
    private $_repository;
    
    /**
     * Sets the account repository
     * 
     * @param string $repository 
     */
    public function setAccountRepository($repository)
    {
        $this->_repository = $this->getEntityManager()->getRepository($repository);
    }
    
    /**
     * Fetches all accounts
     *
     * @return array[App\Entity\Account]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetch an account by it's id
     *
     * @return App\Entity\Account
     */
    public function fetchById($accountId)
    {
        return $this->_repository->find($accountId);
    }

    /**
     * Saves an account
     *
     * @param App\Entity\Account $account
     * @param array $values
     */
    public function saveAccount(App\Entity\Account $account, array $values)
    {
        $typeService = $this->get('service.accounttype');
        $bankService = $this->get('service.bank');
        
        $values['type'] = $typeService->fetchById($values['type']);
        $values['bank'] = $bankService->fetchById($values['bank']);

        $this->_repository->saveAccount($account, $values);
        $this->getEntityManager()->flush();
    }

    /**
     * Removes an account by id
     *
     * @param int $accountId
     */
    public function removeById($accountId)
    {
        $this->_repository->removeAccount($accountId);
        $this->getEntityManager()->flush();
    }

    /**
     * Creates the account options needed for a dropdown
     *
     * @return array
     */
    public function createOptions()
    {
        $types = $this->fetchAll();
        $options = array();
        foreach ($types as $type) {
            $options[$type->getId()] = $type->getName();
        }

        return $options;
    }
}
