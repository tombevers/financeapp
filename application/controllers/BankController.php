<?php

class BankController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        // action body
    }

    public function createAction()
    {
        $form = new Application_Form_Bank(array(
            'action'	=>    $this->_helper->url('save-bank')
        ));
        $this->view->form = $form; 
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function saveBankAction()
    {
       $request = $this->getRequest();
       if (!$request->isPost()) {
           return $this->_helper->redirector('index');
       }
       
       $form = new Application_Form_Bank();
       if (!$form->isValid($request->getPost())) {
           return $this->_helper->redirector('create');
       }
       $values = $form->getValues();
       $this->view->values = $values;
    }
}
