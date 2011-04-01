<?php

namespace App\Entity;

/**
 * @Table(name="transaction_types")
 * @Entity(repositoryClass="App\Entity\Repository\TransactionTypeRepository")
 */
class TransactionType
{
    /**
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     * @GeneratedValue
     * @var int
     */
    private $_id;

    /**
     * @Column(name="tag", length=60)
     * @var string
     */
    private $_tag;

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
    public function getTag()
    {
        return $this->_tag;
    }

    /**
     * @param string $_tag
     */
    public function setTag($_tag)
    {
        $this->_tag = $_tag;
    }
}
