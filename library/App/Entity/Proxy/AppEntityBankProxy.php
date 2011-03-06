<?php

namespace App\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class AppEntityBankProxy extends \App\Entity\Bank implements \Doctrine\ORM\Proxy\Proxy
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

    public function setId($id)
    {
        $this->_load();
        return parent::setId($id);
    }

    public function getName()
    {
        $this->_load();
        return parent::getName();
    }

    public function setName($name)
    {
        $this->_load();
        return parent::setName($name);
    }

    public function getAddress()
    {
        $this->_load();
        return parent::getAddress();
    }

    public function setAddress($address)
    {
        $this->_load();
        return parent::setAddress($address);
    }

    public function getWebsite()
    {
        $this->_load();
        return parent::getWebsite();
    }

    public function setWebsite($website)
    {
        $this->_load();
        return parent::setWebsite($website);
    }

    public function getComment()
    {
        $this->_load();
        return parent::getComment();
    }

    public function setComment($comment)
    {
        $this->_load();
        return parent::setComment($comment);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'address', 'website', 'comment');
    }
}