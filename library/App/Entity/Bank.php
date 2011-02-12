<?php

namespace App\Entity;

/**
 * @Table(name="banks")
 * @Entity
 */
class Bank
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     * @var int
     */
    private $id;
	
    /**
     * @Column(length=60)
     * @var string
     */
    private $name;

    /**
     * @Column(length=150, nullable=true)
     * @var string
     */
    private $address;

    /**
     * @Column(length=150, nullable=true)
     * @var string
     */
    private $website;

    /**
     * @Column(type="text")
     * @var string
     */
    private $comment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
