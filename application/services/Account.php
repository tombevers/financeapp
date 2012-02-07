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
    public function setAccountRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
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
        $account = $this->fetchById($accountId);
        if ($account !== NULL) {
            $this->_repository->removeAccount($account);
            $this->getEntityManager()->flush();
            return TRUE;            
        }
        
        return FALSE;
    }

    /**
     * Creates the account options needed for a dropdown
     *
     * @return array
     */
    public function createOptions()
    {
        $accounts = $this->fetchAll();
        $options = array();
        foreach ($accounts as $account) {
            $options[$account->getId()] = $account->getName();
        }

        return $options;
    }
}
