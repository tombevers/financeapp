<?php

class AccountController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_AccountType
	 */
    private $_accountTypeService;
    
    /**
	 * @var Application_Service_Account
	 */
    private $_accountService;
    
    /**
	 * @var Application_Service_Bank
     */
    private $_bankService;

    public function init()
    {
        $this->_accountTypeService = $this->_helper->serviceContainer('service.accounttype');
        $this->_accountService = $this->_helper->serviceContainer('service.account');
        $this->_bankService = $this->_helper->serviceContainer('service.bank');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->pageTitle = $this->view->translate('accountTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $accounts = $this->_accountService->fetchAll();
        $this->view->accounts = $accounts;
    }

    public function createAction()
    {
        $this->view->pageTitle = $this->view->translate('accountTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        if (count($this->_bankService->fetchAll()) == 0) {
            throw new App\Exception(
                'There are no bank accounts available! Configure them first.'
            );
        }

        $form = new Application_Form_Account(
            array(
                'bankService' => $this->_bankService,
                'typeService' => $this->_accountTypeService,
            )
        );
        $this->view->form = $form;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_accountService->saveAccount(
                    new App\Entity\Account(),
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'saveAccountMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function updateAction()
    {
        $this->view->pageTitle = $this->view->translate('accountTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $request = $this->getRequest();
        $accountId = $request->getParam('id');
        $form = new Application_Form_Account(
            array(
                'bankService' => $this->_bankService,
                'typeService' => $this->_accountTypeService,
            )
        );

        if ($accountId === NULL) {
            throw new App\Exception('Id must be provided for the edit action');
        }

        $account = $this->_accountService->fetchById($accountId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_accountService->saveAccount(
                    $account,
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'editAccountMessage')
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

        $this->_helper->flashMessenger->addMessage(
            array('success' => 'deleteAccountMessage')
        );
        $this->_helper->_redirector('list');
    }
}
