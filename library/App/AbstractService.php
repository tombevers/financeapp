<?php

namespace App;

abstract class AbstractService
{
    /**
    * @var EntityManager
    */
    private $_entityManager = NULL;

    /**
    * @return EntityManager
    */
    public final function getEntityManager()
    {
        if ($this->_entityManager === NULL) {
            $this->_entityManager = \Zend_Controller_Front::getInstance()
                ->getParam('bootstrap')->getContainer()
                ->get('doctrine.entitymanager');
        }
        return $this->_entityManager;
    }

    /**
    * @param EntityManager $entityManager
    * @return AbstractService
    */
    public final function setEntityManager(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
        return $this;
    }
}
