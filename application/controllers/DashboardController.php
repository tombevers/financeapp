<?php

class DashboardController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->pageTitle = $this->view->translate('dashboardTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');
    }

    public function indexAction()
    {
        // action body
    }
}
