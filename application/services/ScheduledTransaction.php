<?php

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Scheduled Transaction service
 */
class Application_Service_ScheduledTransaction extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\ScheduledTransactionRepository
     */
    private $_repository;
    
    /**
     * @var Application_Service_Transaction
     */
    private $_transactionService;
    
    /**
     * @var Application_Service_TransactionType
     */
    private $_typeService;
    
    /**
     * @var Application_Service_Account
     */
    private $_accountService;
    
    /**
     * @var Application_Service_TransactionCategory
     */
    private $_categoryService;

    /**
     * Sets the scheduled transaction repository
     * 
     * @param string $repository 
     */
    public function setScheduledRepository($repository)
    {
        $this->_repository = $this->getEntityManager()->getRepository($repository);
    }

    /**
     * Sets the transaction service
     * 
     * @param string $service 
     */
    public function setTransactionService($service)
    {
        $this->_transactionService = $service;
    }
    
    /**
     * Sets the transaction type service
     * 
     * @param string $service 
     */
    public function setTypeService($service)
    {
        $this->_typeService = $service;
    }

    /**
     * Sets the account service
     * 
     * @param string $service 
     */
    public function setAccountService($service)
    {
        $this->_accountService = $service;
    }
    
    /**
     * Sets the category service
     * 
     * @param string $service 
     */
    public function setCategoryService($service)
    {
        $this->_categoryService = $service;
    }
    
    /**
     * Fetch all transactions order by next date
     *
     * @return array[\App\Entity\ScheduledTransaction]|NULL
     */
    public function fetchAll()
    {
        try {
            return $this->_repository->findAllOrderByNextDate();
        } catch (\Doctrine\ORM\ORMException $exc) {
            return NULL;
        }
    }

    /**
     * Fetch a transaction by id
     *
     * @param int $transactionId
     * @return \App\Entity\ScheduledTransaction
     */
    public function fetchById($transactionId)
    {
        return $this->_repository->find($transactionId);
    }
    
    /**
     * Fetch all pending scheduled transactions
     *
     * @param \DateTime $nextDate
     * @return array[\App\Entity\ScheduledTransaction]|NULL
     */
    public function fetchPending(\DateTime $nextDate)
    {
        try {
            return $this->_repository->findPending($nextDate);
        } catch (\Doctrine\ORM\ORMException $exc) {
            return NULL;
        }
    }
    
    /**
     * Saves a scheduled transaction
     *
     * @param \App\Entity\ScheduledTransaction $transaction
     * @param array $values
     */
    public function saveScheduledTransaction(\App\Entity\ScheduledTransaction $transaction,
        array $values)
    {
        $values['type'] = $this->_typeService->fetchById($values['type']);
        $values['account'] = $this->_accountService->fetchById($values['account']);
        $values['category'] = $this->_categoryService->fetchById($values['category']);
        
        list($year, $month, $day) = explode('-', $values['nextDate']);
        $nextDate = new DateTime();
        $nextDate->setDate($year, $month, $day);
        $values['nextDate'] = $nextDate;

        $this->_repository->saveScheduledTransaction($transaction, $values);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Removes a scheduled transaction
     *
     * @param int $transactionId
     */
    public function removeById($transactionId)
    {
        $this->_repository->removeScheduledTransaction($transactionId);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Adds transactions for all pending scheduled transactions
     */
    public function updatePendingScheduledTransactions()
    {
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0, 0);
        // Fetch all scheduled transactions where next date <= now() and active
        $pendingTransactions = $this->fetchPending($currentDate);
        if (count($pendingTransactions) > 0) {
            foreach ($pendingTransactions as $pendingTransaction) {
                $this->_createTransactions($pendingTransaction, $currentDate);
            }
        }
    }
    
    /**
     * Calculates the next date a pending transaction needs to be executed
     * 
     * @param int $frequency
     * @param \DateTime $nextDate
     * @return \DateTime
     */
    public function calculateNextDate($frequency, \DateTime $nextDate)
    {
        $dateInterval = NULL;
        switch ($frequency) {
            // Daily
            case 1:
                $dateInterval = 'P1D';
                break;
            // Weekly
            case 2:
                $dateInterval = 'P1W';
                break;
            // 2 Weekly
            case 3:
                $dateInterval = 'P2W';
                break;
            // 4 Weekly
            case 4:
                $dateInterval = 'P4W';
                break;
            // Monthly
            case 5:
                $dateInterval = 'P1M';
                break;
            // 2 Montly
            case 6:
                $dateInterval = 'P2M';
                break;
            // 3 Montly
            case 7:
                $dateInterval = 'P3M';
                break;
            // 6 Monthly
            case 8:
                $dateInterval = 'P6M';
                break;
            // Yearly
            case 9:
                $dateInterval = 'P1Y';
                break;
            // One time
            case 0:
            default:
                break;
        }
        
        if ($dateInterval === NULL) {
            return NULL;
        }
        
        return $nextDate->add(new DateInterval($dateInterval));
    }
    
    /**
     * Creates transactions based on the scheduled transaction object and the currentDate
     * 
     * @param \App\Entity\ScheduledTransaction $pendingTransaction
     * @param \DateTime $currentDate 
     */
    private function _createTransactions(\App\Entity\ScheduledTransaction $pendingTransaction, \DateTime $currentDate)
    {
        $oldNextDate = $nextDate = $pendingTransaction->getNextDate();
        $number = $pendingTransaction->getNumber();
        $continuous = $pendingTransaction->isContinuous();
        while (($nextDate !== NULL && $nextDate <= $currentDate) && !(!$continuous && $number <= 0)) {
            $this->_transactionService->saveTransaction(
                new \App\Entity\Transaction,
                array(
                    'type' => $pendingTransaction->getType()->getId(),
                    'account' => $pendingTransaction->getAccount()->getId(),
                    'amount' => $pendingTransaction->getAmount(),
                    'date' => $nextDate->format('Y-m-d'),
                    'note' => '',
                    'category' => $pendingTransaction->getCategory()->getId(),
                )
            );
            $nextDate = $this->calculateNextDate(
                $pendingTransaction->getFrequency(),
                $nextDate
            );

            if (!$continuous) {
                $number--;
            }
        }

        $active = TRUE;
        if ($nextDate === NULL || (!$continuous && $number == 0)) {
            if ($nextDate === NULL) {
                $nextDate = $oldNextDate;
            }

            $active = FALSE;
        }

        $this->saveScheduledTransaction(
            $pendingTransaction,
            array(
                'type' => $pendingTransaction->getType()->getId(),
                'account' => $pendingTransaction->getAccount()->getId(),
                'category' => $pendingTransaction->getCategory()->getId(), 
                'amount' => $pendingTransaction->getAmount(),
                'nextDate' => $nextDate->format('Y-m-d'),
                'frequency' => $pendingTransaction->getFrequency(),
                'continuous' => $pendingTransaction->isContinuous(),
                'number' => $number,
                'active' => $active,
            )
        );        
    }
}
