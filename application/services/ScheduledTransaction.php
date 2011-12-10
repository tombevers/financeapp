<?php

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

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository(
            '\App\Entity\ScheduledTransaction'
        );
        $this->_transactionService = \App\ServiceLocator::getTransactionService();
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
        $typeService = App\ServiceLocator::getTransactionTypeService();
        $values['type'] = $typeService->fetchById($values['type']);
        $accountService = App\ServiceLocator::getAccountService();
        $values['account'] = $accountService->fetchById($values['account']);
        $categoryService = App\ServiceLocator::getTransactionCategoryService();
        $values['category'] = $categoryService->fetchById($values['category']);
        
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
                $oldNextDate = $nextDate = $pendingTransaction->getNextDate();
                $number = $pendingTransaction->getNumber();
                $continuous = $pendingTransaction->isContinuous();
                while (($nextDate !== NULL && $nextDate <= $currentDate) && !(!$continuous && $number <= 0)) {
                    // every scheduled transaction needs to be checked for the frequency,
                    // it should be possible to create more than one transaction per scheduled transaction
                    $values = array(
                        'type' => $pendingTransaction->getType()->getId(),
                        'account' => $pendingTransaction->getAccount()->getId(),
                        'amount' => $pendingTransaction->getAmount(),
                        'date' => $nextDate->format('Y-m-d'),
                        'note' => '',
                        'category' => $pendingTransaction->getCategory()->getId(),
                    );
                    $this->_transactionService->saveTransaction(new \App\Entity\Transaction, $values);
                    $nextDate = $this->calculateNextDate(
                        $pendingTransaction->getFrequency(),
                        $nextDate
                    );
                    
                    if (!$continuous) {
                        $number--;
                    }
                }
                                
                if ($nextDate === NULL) {
                    $nextDate = $oldNextDate;
                }
                
                $active = TRUE;
                if ($nextDate === NULL || (!$continuous && $number == 0)) {
                    $active = FALSE;
                }
                                
                $values = array(
                    'type' => $pendingTransaction->getType()->getId(),
                    'account' => $pendingTransaction->getAccount()->getId(),
                    'category' => $pendingTransaction->getCategory()->getId(), 
                    'amount' => $pendingTransaction->getAmount(),
                    'nextDate' => $nextDate->format('Y-m-d'),
                    'frequency' => $pendingTransaction->getFrequency(),
                    'continuous' => $pendingTransaction->isContinuous(),
                    'number' => $number,
                    'active' => $active,
                );
                $this->saveScheduledTransaction($pendingTransaction, $values);
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
}