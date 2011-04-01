<?php

/**
 * Transaction type service
 */
class Application_Service_TransactionType
{
/**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\TransactionTypeRepository
     */
    private $_repository;

    public function __construct()
    {
        $doctrineContainer = Zend_Registry::get('doctrine');
        $this->_entityManager = $doctrineContainer->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\TransactionType'
        );
    }

    /**
     * Fetches all available transaction types
     *
     * @return array[\App\Entity\TransactionType]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetches an transaction type by id
     *
     * @param int $typeId
     * @return \App\Entity\TransactionType
     */
    public function fetchById($typeId)
    {
        return $this->_repository->find($typeId);
    }

    /**
     * Fetches an transaction type by tag
     *
     * @param string $tag
     * @return \App\Entity\TransactionType
     */
    public function fetchByTag($tag)
    {
        return $this->_repository->findBy(array('tag' => $tag));
    }

    /**
     * Creates the transaction type options needed for a dropdown
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
