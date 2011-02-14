<?php

namespace App\Entity;

/**
 * @Table(name="accounts")
 * @Entity
 */
class Account
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
     * @Column(length=60)
     * @var string
     */
    private $number;

    /**
     * @ManyToOne(targetEntity="Bank")
     * @JoinColumn(name="bankId", referencedColumnName="id")
     */
    private $bank;

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

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getBank()
    {
        return $this->bank;
    }

    public function setBank($bank)
    {
        $this->bank = $bank;
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
