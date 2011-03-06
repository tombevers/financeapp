<?php

namespace App\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class AppEntityPayeeProxy extends \App\Entity\Payee implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setId($_id)
    {
        $this->_load();
        return parent::setId($_id);
    }

    public function getName()
    {
        $this->_load();
        return parent::getName();
    }

    public function setName($_name)
    {
        $this->_load();
        return parent::setName($_name);
    }

    public function getAddress()
    {
        $this->_load();
        return parent::getAddress();
    }

    public function setAddress($_address)
    {
        $this->_load();
        return parent::setAddress($_address);
    }

    public function getPhone()
    {
        $this->_load();
        return parent::getPhone();
    }

    public function setPhone($_phone)
    {
        $this->_load();
        return parent::setPhone($_phone);
    }

    public function getEmail()
    {
        $this->_load();
        return parent::getEmail();
    }

    public function setEmail($_email)
    {
        $this->_load();
        return parent::setEmail($_email);
    }


    public function __sleep()
    {
        return array('__isInitialized__', '_id', '_name', '_address', '_phone', '_email');
    }
}