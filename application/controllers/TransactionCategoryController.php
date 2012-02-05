<?php

class TransactionCategoryController extends Zend_Controller_Action
{
    /**
	 * @var Application_Service_TransactionCategory
	 */
    private $_categoryService;

    public function init()
    {
        $this->_categoryService = $this->_helper->serviceContainer('service.transactioncategory');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionCategoryTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $this->view->category = $this->_categoryService->fetchAllParents();
    }

    public function createAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionCategoryTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $form = new Application_Form_TransactionCategory(
            array(
                'categoryService' => $this->_categoryService,
            )
        );
        $this->view->form = $form;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_categoryService->saveCategory(
                    new App\Entity\TransactionCategory(),
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'saveTransactionCategoryMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function updateAction()
    {
        $this->view->pageTitle = $this->view->translate('transactionCategoryTitle');
        $this->view->headTitle($this->view->pageTitle, 'PREPEND');

        $request = $this->getRequest();
        $categoryId = $request->getParam('id');
        $form = new Application_Form_TransactionCategory(
            array(
                'categoryService' => $this->_categoryService,
            )
        );

        if ($categoryId === NULL) {
            throw new App\Exception('Id must be provided for the edit action');
        }

        $category = $this->_categoryService->fetchById($categoryId);

        if ($request->isPost()) {
            $formData = $request->getPost();
            if ($form->isValid($formData)) {
                $this->_categoryService->saveCategory(
                    $category,
                    $form->getValues()
                );

                $this->_helper->flashMessenger->addMessage(
                    array('success' => 'editTransactionCategoryMessage')
                );
                $this->_helper->_redirector('list');
            } else {
                $form->populate($formData);
            }
        } else {
            $form->setDefaultsFromEntity($category);
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $categoryId = $request->getParam('id');

        if ($categoryId === NULL) {
            throw new App\Exception(
                'Id must be provided for the delete action'
            );
        }

        $this->_categoryService->removeById($categoryId);

        $this->_helper->flashMessenger->addMessage(
            array('success' => 'deleteTransactionCategoryMessage')
        );
        $this->_helper->_redirector('list');
    }
}
