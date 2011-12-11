<?php

namespace App\Entity;

/**
 * @Table(name="settings")
 * @Entity(repositoryClass="App\Entity\Repository\SettingRepository")
 */
class Setting
{
    /**
     * @Id
     * @Column(length=16, type="string")
     * @var string
     */
    private $parameter;

    /**
     * @Column(length=150, type="string")
     * @var string
     */
    private $value;
    
    /**
     * Creates a setting
     * 
     * @param string $parameter
     * @param string $value 
     */
    public function __construct($parameter, $value)
    {
        $this->parameter = $parameter;
        $this->value = $value;
    }
    
    /**
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }
    
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param setting $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}