<?php

/**
 * Setting service
 */
class Application_Service_Setting extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\SettingRepository
     */
    private $_repository;
    
    /**
     * @var array
     */
    private $_currencies = array(
        'EUR' => array('Euro', '€'),
        'GBP' => array('Pond Sterling', '£'),
        'USD' => array('United States Dollar', '$'),
        'YEN' => array('Yen', '¥'),
    );

    public function setSettingRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
    }
    
    /**
     * Fetches all settings
     *
     * @return array[App\Entity\Setting]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }
    
    /**
     * Fetch a setting by a parameter
     * 
     * @param string $parameter
     * @return App\Entity\Setting
     */
    public function fetchByParameter($parameter)
    {
        $criteria = array(
            'parameter' => $parameter
        );
        return $this->_repository->findOneBy($criteria);
    }
    
    /**
     * Saves the settings
     *
     * @param array $values
     */
    public function saveSettings(array $values)
    {
        if (empty($values)) {
            return FALSE;
        }
        
        foreach ($values as $parameter => $value) {
            $setting = $this->fetchByParameter($parameter);
            
            if ($setting !== NULL) {
                $this->_repository->saveSetting($setting, $value);
            }
        }
        $this->getEntityManager()->flush();
        return TRUE;
    }
    
    /**
     * Create the currency options
     * 
     * @return array 
     */
    public function createCurrencyOptions()
    {
        $options = array();
        foreach ($this->_currencies as $iso => $value) {
            $options[$iso] = $value[0];
        }
        return $options;
    }
    
    /**
     * Gets the currency symbol
     * 
     * @param string $iso 
     */
    public function getCurrenySymbol($iso)
    {
        if (!array_key_exists($iso, $this->_currencies)) {
            return NULL;
        }
        
        list(, $symbol) = $this->_currencies[$iso];
        return $symbol;
    }
}
