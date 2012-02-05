<?php

namespace App\Controller\Plugin;

class ScheduledTransaction extends \Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(\Zend_Controller_Request_Abstract $request)
    {
        $container = \Zend_Controller_Front::getInstance()->getParam('bootstrap')->getContainer();
        $service = $container->get('service.scheduledtransaction');
        $service->updatePendingScheduledTransactions();
    }
}
