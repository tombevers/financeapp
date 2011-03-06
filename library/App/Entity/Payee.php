<?php

namespace App\Entity;

/**
 * @Table(name="payees")
 * @Entity(repositoryClass="App\Entity\Repository\PayeeRepository")
 */
class Payee
{
    /**
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     * @GeneratedValue
     * @var int
     */
    private $_id;
    
    /**
     * @Column(name="name", length=60)
     * @var string
     */
    private $_name;
    
    /**
     * @Column(name="address", length=150, nullable=true)
     * @var string
     */
    private $_address;
    
    /**
     * @Column(name="phone", length=150, nullable=true)
     * @var string
     */
    private $_phone;
    
    /**
     * @Column(name="email", length=150, nullable=true)
     * @var string
     */
    private $_email;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $_id 
     */
    public function setId($_id)
    {
        $this->_id = $_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $_name 
     */
    public function setName($_name)
    {
        $this->_name = $_name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param string $_address
     */
    public function setAddress($_address)
    {
        $this->_address = $_address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param string $_phone 
     */
    public function setPhone($_phone)
    {
        $this->_phone = $_phone;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $_email
     */
    public function setEmail($_email)
    {
        $this->_email = $_email;
    }
}
