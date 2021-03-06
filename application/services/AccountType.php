<?php

/**
 * Account type service
 */
class Application_Service_AccountType extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\AccountTypeRepository
     */
    private $_repository;

    public function setAccountTypeRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
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
