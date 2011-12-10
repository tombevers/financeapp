<?php

namespace App\Entity;

/**
 * @Table(name="configuration")
 * @Entity
 */
class Configuration
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
     * Creates a configuration
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
}