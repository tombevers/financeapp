<?php

class BankController extends Zend_Controller_Action
{
	/**
	 * @var Application_Service_Bank
	 */
    private $_bankService;
    
    public function init()
    {
        $this->_bankService = \App\ServiceLocator::getBankService();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $banks = $this->_bankService->fetchAll();
        $this->view->banks = $banks;
    }

    public function addAction()
    {
        $form = new Application_Form_Bank();
        $this->view->form = $form;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_bankService->saveBank(
                    new App\Entity\Bank(),
                    $form->getValues()
                );
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $bankId = $request->getParam('id');
        $form = new Application_Form_Bank();
        
        if ($bankId === NULL) {
            throw new Exception('Id must be provided for the edit action');
        }

        $bank = $this->_bankService->fetchById($bankId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_bankService->saveBank($bank, $form->getValues());
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($bank);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $bankId = $request->getParam('id');

        if ($bankId === NULL) {
            throw new Exception('Id must be provided for the delete action');
        }

        $this->_bankService->removeById($bankId);

        $this->_helper->_redirector('list');
    }
}
