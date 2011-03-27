<?php

namespace App\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class AppEntityTransactionProxy extends \App\Entity\Transaction implements \Doctrine\ORM\Proxy\Proxy
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

    public function getType()
    {
        $this->_load();
        return parent::getType();
    }

    public function setType($_type)
    {
        $this->_load();
        return parent::setType($_type);
    }

    public function getAccount()
    {
        $this->_load();
        return parent::getAccount();
    }

    public function setAccount($_account)
    {
        $this->_load();
        return parent::setAccount($_account);
    }

    public function getAmount()
    {
        $this->_load();
        return parent::getAmount();
    }

    public function setAmount($_amount)
    {
        $this->_load();
        return parent::setAmount($_amount);
    }

    public function getDate()
    {
        $this->_load();
        return parent::getDate();
    }

    public function setDate($_date)
    {
        $this->_load();
        return parent::setDate($_date);
    }

    public function getNote()
    {
        $this->_load();
        return parent::getNote();
    }

    public function setNote($_note)
    {
        $this->_load();
        return parent::setNote($_note);
    }


    public function __sleep()
    {
        return array('__isInitialized__', '_id', '_type', '_account', '_amount', '_date', '_note');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}