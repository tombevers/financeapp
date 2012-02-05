<?php

namespace App;

use Doctrine\ORM\EntityManager;

class AbstractService
{
    /**
    * @var EntityManager
    */
    private $_entityManager;

    /**
    * @return EntityManager
    */
    public final function getEntityManager()
    {
        return $this->_entityManager;
    }

    /**
    * @param EntityManager $entityManager
    */
    public final function setEntityManager(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }
    
    /**
     * Gets your configured DI symfony service 
     *
     * @param string $service
     */
    public function get($service)
    {
        return \Zend_Controller_Front::getInstance()
            ->getParam('bootstrap')->getContainer()
            ->get($service);
    }
}
