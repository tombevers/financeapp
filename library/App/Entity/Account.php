<?php

namespace App\Entity;

/**
 * @Table(name="accounts")
 * @Entity(repositoryClass="App\Entity\Repository\AccountRepository")
 */
class Account
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
     * @Column(name="number", length=60, nullable=true)
     * @var string
     */
    private $_number;

    /**
     * @ManyToOne(targetEntity="Bank")
     * @JoinColumn(name="bankId", referencedColumnName="id")
     */
    private $_bank;

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
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param string $_number 
     */
    public function setNumber($_number)
    {
        $this->_number = $_number;
    }

    /**
     * @return \App\Entity\Bank
     */
    public function getBank()
    {
        return $this->_bank;
    }

    /**
     *
     * @param \App\Entity\Bank $_bank 
     */
    public function setBank($_bank)
    {
        $this->_bank = $_bank;
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
