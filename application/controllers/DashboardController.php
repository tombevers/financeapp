<?php

class DashboardController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->title = $this->view->translate('dashboardTitle');
        $this->view->headTitle($this->view->title, 'PREPEND');
    }

    public function indexAction()
    {
        // action body
    }


}

