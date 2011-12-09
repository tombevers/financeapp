<?php

namespace App\Controller\Plugin;

class ScheduledTransaction extends \Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(\Zend_Controller_Request_Abstract $request)
    {
        $service = \App\ServiceLocator::getScheduledTransactionService();
        $service->updatePendingScheduledTransactions();
    }
}
