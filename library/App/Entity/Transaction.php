<?php

namespace App\Entity;

/**
 * @Table(name="transactions")
 * @Entity(repositoryClass="App\Entity\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     * @GeneratedValue
     * @var int
     */
    private $_id;

    /**
     * @ManyToOne(targetEntity="TransactionType")
     * @JoinColumn(name="typeId", referencedColumnName="id")
     */
    private $_type;

    /**
     * @ManyToOne(targetEntity="Account")
     * @JoinColumn(name="accountId", referencedColumnName="id")
     */
    private $_account;
    
    /**
     * @ManyToOne(targetEntity="TransactionCategory")
     * @JoinColumn(name="categoryId", referencedColumnName="id")
     */
    private $_category;

    /**
     * @Column(name="amount", type="decimal", scale=2)
     * @var double
     */
    private $_amount;

    /**
     * @column(name="date", type="date")
     * @var \DateTime
     */
    private $_date;

    /**
     * @column(name="note")
     * @var string
     */
    private $_note;

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
     * @return \App\Entity\TransactionType
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param \App\Entity\TransactionType $_type
     */
    public function setType($_type)
    {
        $this->_type = $_type;
    }

    /**
     * @return \App\Entity\Account
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * @param \App\Entity\Account $_account
     */
    public function setAccount($_account)
    {
        $this->_account = $_account;
    }

    /**
     * @return \App\Entity\TransactionCategory
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * @param \App\Entity\TransactionCategory $_category 
     */
    public function setCategory($_category)
    {
        $this->_category = $_category;
    }
    
    /**
     * @return double
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param double $_amount
     */
    public function setAmount($_amount)
    {
        $this->_amount = $_amount;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @param \DateTime $_date
     */
    public function setDate($_date)
    {
        $this->_date = $_date;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->_note;
    }

    /**
     * @param string $_note
     */
    public function setNote($_note)
    {
        $this->_note = $_note;
    }
}
