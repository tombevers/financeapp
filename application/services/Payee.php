<?php

/**
 * Payee service
 */
class Application_Service_Payee extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\PayeeRepository
     */
    private $_repository;

    public function setPayeeRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
    }

    /**
     * Fetch all payees
     *
     * @return array[\App\Entity\Payee]
     */
    public function fetchAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * Fetch a payee by id
     *
     * @param int $payeeId
     * @return \App\Entity\Payee
     */
    public function fetchById($payeeId)
    {
        return $this->_repository->find($payeeId);
    }

    /**
     * Saves a payee
     *
     * @param \App\Entity\Payee $payee
     * @param array $values
     */
    public function savePayee(\App\Entity\Payee $payee, array $values)
    {
        $payee = $this->_repository->savePayee($payee, $values);
        $this->getEntityManager()->flush();
        return $payee;
    }

    /**
     * Removes a payee
     *
     * @param int $payeeId
     */
    public function removeById($payeeId)
    {
        $payee = $this->fetchById($payeeId);
        if ($payee === NULL) {
            return FALSE;
        }
        
        $this->_repository->removePayee($payee);
        $this->getEntityManager()->flush();
        return TRUE;
    }
}
