<?php

/**
 * Bank service
 */
class Application_Service_Bank extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\BankRepository
     */
    private $_repository;
    
    public function setBankRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;        
    }

    /**
     * Fetch all banks
     *
     * @return array[\App\Entity\Bank]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetch a bank by id
     *
     * @param int $bankId
     * @return \App\Entity\Bank
     */
    public function fetchById($bankId)
    {
        return $this->_repository->find($bankId);
    }

    /**
     * Saves a bank
     *
     * @param \App\Entity\Bank $bank
     * @param array $values
     * @return \App\Entity\Bank
     */
    public function saveBank(\App\Entity\Bank $bank, array $values)
    {
        $bank = $this->_repository->saveBank($bank, $values);
        $this->getEntityManager()->flush();
        
        return $bank;
    }

    /**
     * Removes a bank
     *
     * @param int $bankId
     */
    public function removeById($bankId)
    {
        $bank = $this->fetchById($bankId);
        if ($bank !== NULL) {
            $this->_repository->removeBank($bank);
            $this->getEntityManager()->flush();
            return TRUE;            
        }
        
        return FALSE;
    }

    /**
     * Creates the account type options needed for a dropdown
     *
     * @return array
     */
    public function createOptions()
    {
        $banks = $this->fetchAll();
        $options = array();
        foreach ($banks as $bank) {
            $options[$bank->getId()] = $bank->getName();
        }

        return $options;
    }
}
