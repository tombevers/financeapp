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
        $typeService = App\ServiceLocator::getAccountTypeService();
        $values['type'] = $typeService->fetchById($values['type']);
        $bankService = App\ServiceLocator::getBankService();
        $values['bank'] = $bankService->fetchById($values['bank']);

        $this->_repository->saveAccount($account, $values);
        $this->_entityManager->flush();
    }

    /**
     * Removes an account by id
     *
     * @param int $accountId
     */
    public function removeById($accountId)
    {
        $this->_repository->removeAccount($accountId);
        $this->_entityManager->flush();
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
