<?php

/**
 * Transaction service
 */
class Application_Service_Transaction extends App\AbstractService
{
    /**
     * @var \App\Entity\Repository\TransactionRepository
     */
    private $_repository;
    
    /**
     * Sets the transaction repository
     * 
     * @param string $repository 
     */
    public function setTransactionRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
    }
    
    /**
     * Fetch all transactions
     *
     * @return array[\App\Entity\Transaction]
     */
    public function fetchAll()
    {
        try {
            return $this->_repository->findAllOrderByDate();
        } catch (\Doctrine\ORM\ORMException $exc) {
            return NULL;
        }
    }

    /**
     * Fetch a transaction by id
     *
     * @param int $transactionId
     * @return \App\Entity\Transaction
     */
    public function fetchById($transactionId)
    {
        return $this->_repository->find($transactionId);
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
        $columns = array('_date', '_amount');
        
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
            $data[] = array($result['date']->format('Y-m-d'), $result['amount'], $actions);
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
        $actions .= '<a href="/transaction/update/id/' . $id. '">Edit</a>';
        $actions .= '</li>';
        $actions .= '<li>';
        $actions .= '<a href="/transaction/delete/id/' . $id. '">Delete</a>';
        $actions .= '</li>';
        $actions .= '</ul>';
        
        return $actions;
    }
    
    /**
     * Saves a transaction
     *
     * @param \App\Entity\Transaction $transaction
     * @param array $values
     */
    public function saveTransaction(\App\Entity\Transaction $transaction,
        array $values)
    {
        $typeService = $this->get('service.transactiontype');
        $accountService = $this->get('service.account');
        $categoryService = $this->get('service.transactioncategory');
        
        $values['type'] = $typeService->fetchById($values['type']);
        $values['account'] = $accountService->fetchById($values['account']);
        $values['category'] = $categoryService->fetchById($values['category']);
        
        list($year, $month, $day) = explode('-', $values['date']);
        $date = new DateTime();
        $date->setDate($year, $month, $day);
        $values['date'] = $date;

        $this->_repository->saveTransaction($transaction, $values);
        $this->getEntityManager()->flush();
    }

    /**
     * Removes a transaction
     *
     * @param int $transactionId
     */
    public function removeById($transactionId)
    {
        $this->_repository->removeTransaction($transactionId);
        $this->getEntityManager()->flush();
    }
}
