<?php

class AccountController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_Account
	 */
    private $_accountService;
    
    public function init()
    {
        $this->_accountService = \App\ServiceLocator::getAccountService();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $accounts = $this->_accountService->fetchAll();
        $this->view->accounts = $accounts;
    }

    public function addAction()
    {
        $form = new Application_Form_Account();
        $this->view->form = $form;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_accountService->saveAccount(
                    new App\Entity\Account(),
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
        $accountId = $request->getParam('id');
        $form = new Application_Form_Account();
        
        if ($accountId === NULL) {
            throw new Exception('Id must be provided for the edit action');
        }

        $account = $this->_accountService->fetchById($accountId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_accountService->saveAccount(
                    $account,
                    $form->getValues()
                );
                
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($account);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $accountId = $request->getParam('id');

        if ($accountId === NULL) {
            throw new Exception('Id must be provided for the delete action');
        }

        $this->_accountService->removeById($accountId);

        $this->_helper->_redirector('list');
    }
}
