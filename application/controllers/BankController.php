<?php

class BankController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_Bank
	 */
    private $_bankService;

    public function init()
    {
        $this->_bankService = $this->_helper->serviceContainer('service.bank');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->pageTitle = $this->view->translate('bankTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $banks = $this->_bankService->fetchAll();
        $this->view->banks = $banks;
    }

    public function createAction()
    {
        $this->view->pageTitle = $this->view->translate('bankTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

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

                
                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'saveBankMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function updateAction()
    {
        $this->view->pageTitle = $this->view->translate('bankTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $request = $this->getRequest();
        $bankId = $request->getParam('id');
        $form = new Application_Form_Bank();

        if ($bankId === NULL) {
            throw new App\Exception('Id must be provided for the edit action');
        }

        $bank = $this->_bankService->fetchById($bankId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_bankService->saveBank($bank, $form->getValues());

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'editBankMessage')
                );
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
            throw new App\Exception(
                'Id must be provided for the delete action'
            );
        }

        $this->_bankService->removeById($bankId);

        $this->_helper->flashMessenger->addMessage(
            array('success' => 'deleteBankMessage')
        );
        $this->_helper->_redirector('list');
    }
}
