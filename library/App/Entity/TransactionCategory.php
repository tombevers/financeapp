<?php

namespace App\Entity;

/**
 * @Table(name="transaction_categories")
 * @Entity(repositoryClass="App\Entity\Repository\TransactionCategoryRepository")
 */
class TransactionCategory
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
     */
    private $_name;
    
    /**
     * @OneToMany(targetEntity="TransactionCategory", mappedBy="_parent")
     */
    private $_children;
    
    /**
     * @ManyToOne(targetEntity="TransactionCategory", inversedBy="_children")
     * @JoinColumn(name="parentId", referencedColumnName="id")
     */
    private $_parent;

    public function __construct()
    {
        $this->_children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * @param \App\Entity\TransactionCategory $_parent
     */
    public function setParent($_parent)
    {
        $this->_parent = $_parent;
    }
    
    /**
     * @return \App\Entity\TransactionCategory
     */
    public function getParent()
    {
        return $this->_parent;
    }
    
    /**
     * @return array[\App\Entity\TransactionCategory]|NULL
     */
    public function getChildren()
    {
        return $this->_children;
    }
}
