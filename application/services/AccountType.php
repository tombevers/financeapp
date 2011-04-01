<?php

/**
 * Account type service
 */
class Application_Service_AccountType
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\AccountTypeRepository
     */
    private $_repository;

    public function __construct()
    {
        $doctrineContainer = Zend_Registry::get('doctrine');
        $this->_entityManager = $doctrineContainer->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\AccountType'
        );
    }

    /**
     * Fetches all available account types
     *
     * @return array[\App\Entity\AccountType]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetches an account type by id
     *
     * @param int $typeId
     * @return \App\Entity\AccountType
     */
    public function fetchById($typeId)
    {
        return $this->_repository->find($typeId);
    }

    /**
     * Fetches an account type by tag
     *
     * @param string $tag
     * @return \App\Entity\AccountType
     */
    public function fetchByTag($tag)
    {
        return $this->_repository->findBy(array('tag' => $tag));
    }

    /**
     * Creates the account type options needed for a dropdown
     *
     * @return array
     */
    public function createOptions()
    {
        $types = $this->fetchAll();
        $options = array();
        foreach ($types as $type) {
            $options[$type->getId()] = $type->getTag();
        }

        return $options;
    }
}
