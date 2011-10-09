<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    App\Entity\TransactionCategory;

class TransactionCategoryRepository extends EntityRepository
{
    /**
     * Saves a category
     * 
     * @param TransactionCategory $category
     * @param array $values 
     */
    public function saveCategory(TransactionCategory $category, array $values)
    {
        $category->setName($values['name']);
        $category->setParent($values['parent']);

        $this->getEntityManager()->persist($category);
    }
    
    /**
     * Remove a category
     * @param int $categoryId 
     */
    public function removeCategory($categoryId)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\App\Entity\TransactionCategory', $categoryId);

        $em->remove($proxy);
    }
}
