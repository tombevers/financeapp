<?php

/**
 * Transaction category service
 */
class Application_Service_TransactionCategory extends App\AbstractService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @var \App\Entity\Repository\TransactionCategoryRepository
     */
    private $_repository;

    public function __construct()
    {
        $this->_entityManager = $this->getEntityManager();
        $this->_repository = $this->_entityManager->getRepository(
            '\App\Entity\TransactionCategory'
        );
    }

    /**
     * Fetches all available transaction types
     *
     * @return array[\App\Entity\TransactionCategory]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetches an transaction category by id
     *
     * @param int $categoryId
     * @return \App\Entity\TransactionCategory
     */
    public function fetchById($categoryId)
    {
        return $this->_repository->find($categoryId);
    }

    /**
     * Fetches all parents
     * 
     * @return array[\App\Entity\TransactionCategory]
     */
    public function fetchAllParents()
    {
        return $this->_repository->findBy(
            array('_parent' => NULL)
        );
    }
    
    /**
     * Saves a category
     *
     * @param \App\Entity\TransactionCategory $category
     * @param array $values
     */
    public function saveCategory(\App\Entity\TransactionCategory $category,
        array $values)
    {
        $values['parent'] = $this->fetchById($values['parent']);
        
        $this->_repository->saveCategory($category, $values);
        $this->_entityManager->flush();
    }

    /**
     * Removes a category
     *
     * @param int $categoryId
     */
    public function removeById($categoryId)
    {
        $this->_repository->removeCategory($categoryId);
        $this->_entityManager->flush();
    }

    /**
     * Creates the transaction category options needed for a dropdown
     *
     * @param boolean $emptyItem
     * @param boolean $listChildren
     * @return array
     */
    public function createOptions($emptyItem = FALSE, $listChildren = TRUE)
    {
        $categories = $this->fetchAllParents();
        $options = array();
        if ($emptyItem) {
            $options[0] = 'None'; // @todo translate
        }
        
        foreach ($categories as $category) {
            $options[$category->getId()] = $category->getName();
            if ($listChildren) {
                foreach ($category->getChildren() as $child) {
                    $options[$child->getId()] = $child->getName();
                }
            }
        }

        return $options;
    }
}
