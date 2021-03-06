<?php

class TransactionController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_Transaction
	 */
    private $_transactionService;
    
    /**
	 * @var Application_Service_Account
	 */
    private $_accountService;
    
    /**
     * @var Application_Service_TransactionType
     */
    private $_typeService;
    
    /**
     * @var Application_Service_TransactionCategory
     */
    private $_categoryService;

    public function init()
    {
        $this->_transactionService = $this->_helper->serviceContainer('service.transaction');
        $this->_accountService = $this->_helper->serviceContainer('service.account');
        $this->_typeService = $this->_helper->serviceContainer('service.transactiontype');
        $this->_categoryService = $this->_helper->serviceContainer('service.transactioncategory');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');
        
        $this->view->headScript()->appendFile('/js/application/transaction/list.js');
    }

    public function createAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        if (count($this->_accountService->fetchAll()) == 0) {
            throw new App\Exception(
                'There are no accounts available! Configure them first.'
            );
        }
        
        if (count($this->_categoryService->fetchAll()) == 0) {
            throw new App\Exception(
                'There are no categories available! Configure them first.'
            );
        }

        $form = new Application_Form_Transaction(
            array(
                'accountService' => $this->_accountService,
                'typeService' => $this->_typeService,
                'categoryService' => $this->_categoryService,
            )
        );
        $this->view->form = $form;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_transactionService->saveTransaction(
                    new App\Entity\Transaction(),
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'saveTransactionMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function updateAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $request = $this->getRequest();
        $transactionId = $request->getParam('id');
        $form = new Application_Form_Transaction(
            array(
                'accountService' => $this->_accountService,
                'typeService' => $this->_typeService,
                'categoryService' => $this->_categoryService,
            )
        );

        if ($transactionId === NULL) {
            throw new App\Exception('Id must be provided for the edit action');
        }

        $transaction = $this->_transactionService->fetchById($transactionId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_transactionService->saveTransaction(
                    $transaction,
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'editTransactionMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($transaction);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $transactionId = $request->getParam('id');

        if ($transactionId === NULL) {
            throw new App\Exception(
                'Id must be provided for the delete action'
            );
        }

        $this->_transactionService->removeById($transactionId);

        $this->_helper->flashMessenger->addMessage(
            array('success' => 'deleteTransactionMessage')
        );
        $this->_helper->_redirector('list');
    }
    
    public function getGridDataAction()
    {
        $params = $this->getRequest()->getParams();
        return $this->_helper->json($this->_transactionService->fetchGridData($params));
    }
}
