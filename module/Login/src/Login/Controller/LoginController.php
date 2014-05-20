<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\Login;
use Login\Form\LoginForm;

class LoginController extends AbstractActionController
{
	protected $loginTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             //'logins' => $this->getLoginTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
//     	$form = new LoginForm();
//     	$form->get('submit')->setValue('Add');
    	
//     	$request = $this->getRequest();
//     	if ($request->isPost()) {
//     		$login = new Login();
//     		$form->setInputFilter($login->getInputFilter());
//     		$form->setData($request->getPost());
    	
//     		if ($form->isValid()) {
//     			$login->exchangeArray($form->getData());
//     			$this->getLoginTable()->saveLogin($login);
    	
//     			// Redirect to list of logins
//     			return $this->redirect()->toRoute('login');
//     		}
//     	}
//     	return array('form' => $form);    	
    }

    public function editAction()
    {
//     	$id = (int) $this->params()->fromRoute('id', 0);
//     	if (!$id) {
//     		return $this->redirect()->toRoute('login', array(
//     				'action' => 'add'
//     		));
//     	}
    	
//     	// Get the Login with the specified id.  An exception is thrown
//     	// if it cannot be found, in which case go to the index page.
//     	try {
//     		$login = $this->getLoginTable()->getLogin($id);
//     	}
//     	catch (\Exception $ex) {
//     		return $this->redirect()->toRoute('login', array(
//     				'action' => 'index'
//     		));
//     	}
    	
//     	$form  = new LoginForm();
//     	$form->bind($login);
//     	$form->get('submit')->setAttribute('value', 'Edit');
    	
//     	$request = $this->getRequest();
//     	if ($request->isPost()) {
//     		$form->setInputFilter($login->getInputFilter());
//     		$form->setData($request->getPost());
    	
//     		if ($form->isValid()) {
//     			$this->getLoginTable()->saveLogin($login);
    	
//     			// Redirect to list of logins
//     			return $this->redirect()->toRoute('login');
//     		}
//     	}
    	
//     	return array(
//     			'id' => $id,
//     			'form' => $form,
//     	);    	
    }

    public function deleteAction()
    {
//     	$id = (int) $this->params()->fromRoute('id', 0);
//     	if (!$id) {
//     		return $this->redirect()->toRoute('login');
//     	}
    	
//     	$request = $this->getRequest();
//     	if ($request->isPost()) {
//     		$del = $request->getPost('del', 'No');
    	
//     		if ($del == 'Yes') {
//     			$id = (int) $request->getPost('id');
//     			$this->getLoginTable()->deleteLogin($id);
//     		}
    	
//     		// Redirect to list of logins
//     		return $this->redirect()->toRoute('login');
//     	}
    	
//     	return array(
//     			'id'    => $id,
//     			'login' => $this->getLoginTable()->getLogin($id)
//     	);    	
    }
    
    public function getLoginTable()
    {
//     	if (!$this->loginTable) {
//     		$sm = $this->getServiceLocator();
//     		$this->loginTable = $sm->get('Login\Model\LoginTable');
//     	}
//     	return $this->loginTable;
     }    
}