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
     * Sets the scheduled transaction repository
     * 
     * @param string $repository 
     */
    public function setScheduledRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
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
        $typeService = $this->get('service.transactiontype');
        $accountService = $this->get('service.account');
        $categoryService = $this->get('service.transactioncategory');
        
        $values['type'] = $typeService->fetchById($values['type']);
        $values['account'] = $accountService->fetchById($values['account']);
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
     * @return boolean 
     */
    public function removeById($transactionId)
    {
        $transaction = $this->fetchById($transactionId);
        if ($transaction !== NULL) {
            $this->_repository->removeScheduledTransaction($transaction);
            $this->getEntityManager()->flush();
            return TRUE;            
        }
        
        return FALSE;
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
        $intervals = array(
            1 => 'P1D',
            2 => 'P1W',
            3 => 'P2W',
            4 => 'P4W',
            5 => 'P1M',
            6 => 'P2M',
            7 => 'P3M',
            8 => 'P6M',
            9 => 'P1Y',
        );
        
        if (!array_key_exists($frequency, $intervals)) {
            return NULL;
        }
        
        return $nextDate->add(new DateInterval($intervals[$frequency]));
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

        $transactionService = $this->get('service.transaction');
        while (($nextDate !== NULL && $nextDate <= $currentDate) && !(!$continuous && $number <= 0)) {
            $transactionService->saveTransaction(
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
    
    /**
     * Fetches data for the grid
     * 
     * @param array $params
     * @return array
     */
    public function fetchGridData(array $params)
    {
        $firstResult = $params['iDisplayStart'];
        $maxResults = $params['iDisplayLength'];
        $echo = $params['sEcho'];
        $search = $params['sSearch'];
        $columns = array('st._nextDate', 'st._frequency', 't._tag', 'c._name', 'st._amount', 'st._active');
        
        $sorting = array();
        for ($i = 0 ; $i < intval($params['iSortingCols']); $i++) {
            $column = intval($params['iSortCol_' . $i]);
            $order = $params['sSortDir_' . $i];
            
            if ($params['bSortable_' . $column]) {
                if (array_key_exists($column, $columns)) {
                    $sorting[] = array(
                        'column' => $columns[$column],
                        'order' => $order
                    );
                }
            }
        }
        
        $filters = array();
        if (!empty($search)) {
            for ($i = 0; $i < count($columns); $i++) {
                $filters[] = array(
                    'column' => $columns[$i],
                    'filter' => $search,
                );
            }
        }
        
        $results = $this->_repository->findGridData($firstResult, $maxResults, $sorting, $filters);
        $totalRecords = $results[0];
        
        $data = array();
        foreach ($results[1] as $result) {
            $actions = $this->_getActionLink($result['id']);
            $data[] = array(
                $result['nextDate']->format('Y-m-d'),
                $result['frequency'],
                $result['type'],
                $result['category'],
                $result['amount'],
                $result['active'],
                $actions
            );
        }
        
        $output = array(
            "sEcho" => intval($echo),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $output;
    }
    
    private function _getActionLink($id)
    {
        $actions = '<ul class="actions clearfix">';
        $actions .= '<li>';
        $actions .= '<a href="/scheduled-transaction/update/id/' . $id. '">Edit</a>';
        $actions .= '</li>';
        $actions .= '<li>';
        $actions .= '<a href="/scheduled-transaction/delete/id/' . $id. '">Delete</a>';
        $actions .= '</li>';
        $actions .= '</ul>';
        
        return $actions;
    }    
}
