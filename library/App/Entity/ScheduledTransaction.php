<?php

namespace App\Entity;

/**
 * @Table(name="scheduled_transactions")
 * @Entity(repositoryClass="App\Entity\Repository\ScheduledTransactionRepository")
 */
class ScheduledTransaction
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
     */
    private $_amount;
    
    /**
     * @Column(name="nextDate", type="date")
     */
    private $_nextDate;
    
    /**
     * @Column(name="frequency", type="string")
     */
    private $_frequency;
    
    /**
     * @Column(name="continuous", type="boolean")
     */
    private $_continuous;
    
    /**
     * @Column(name="number", type="integer")
     */
    private $_number;
    
    /**
     * @Column(name="active", type="boolean")
     */
    private $_active;

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
    public function getNextDate()
    {
        return $this->_nextDate;
    }

    /**
     * @param \DateTime $_nextDate
     */
    public function setNextDate($_nextDate)
    {
        $this->_nextDate = $_nextDate;
    }

    public function getFrequency()
    {
        return $this->_frequency;
    }
    
    public function setFrequency($_frequency)
    {
        $this->_frequency = $_frequency;
    }
    
    /**
     * @return boolean
     */
    public function isContinuous()
    {
        return $this->_continuous;
    }

    /**
     * @param boolean $_continuous 
     */
    public function setContinuous($_continuous)
    {
        $this->_continuous = $_continuous;
    }
    
    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param int $_number 
     */
    public function setNumber($_number)
    {
        $this->_number = $_number;
    }
    
    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->_active;
    }

    /**
     * @param boolean $_active 
     */
    public function setActive($_active)
    {
        $this->_active = $_active;
    }
}
