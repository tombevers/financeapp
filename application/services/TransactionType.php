<?php

/**
 * Transaction type service
 */
class Application_Service_TransactionType extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\TransactionTypeRepository
     */
    private $_repository;

    public function setTransactionTypeRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
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
