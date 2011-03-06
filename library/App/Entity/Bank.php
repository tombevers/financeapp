<?php

namespace App\Entity;

/**
 * @Table(name="banks")
 * @Entity(repositoryClass="App\Entity\Repository\BankRepository")
 */
class Bank
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
     * @Column(name="address",length=150, nullable=true)
     * @var string
     */
    private $_address;

    /**
     * @Column(name="website", length=150, nullable=true)
     * @var string
     */
    private $_website;

    /**
     * @Column(name="comment", nullable=true)
     * @var string
     */
    private $_comment;

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
    public function getWebsite()
    {
        return $this->_website;
    }

    /**
     * @param string $_website 
     */
    public function setWebsite($_website)
    {
        $this->_website = $_website;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @param string $_comment 
     */
    public function setComment($_comment)
    {
        $this->_comment = $_comment;
    }
}
