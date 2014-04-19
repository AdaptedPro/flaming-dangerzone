<?php
namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Model\Dashboard;
use Dashboard\Form\DashboardForm;

class DashboardController extends AbstractActionController
{
	protected $dashboardTable;
	
    public function indexAction()
    {
        $msg = isset($_SESSION['login_message'])?$_SESSION['login_message']:'';
    	return new ViewModel(array(
             'dashboards' => $this->getDashboardTable()->fetchAll(),
         	 'displayname' => isset($_SESSION['auth_user']['email'])?$_SESSION['auth_user']['email']:'Guest',
    		 'message' => $msg
         ));
    }

    public function addAction()
    {
    	$form = new DashboardForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dashboard = new Dashboard();
    		$form->setInputFilter($dashboard->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$dashboard->exchangeArray($form->getData());
    			$this->getDashboardTable()->saveDashboard($dashboard);
    	
    			// Redirect to list of dashboards
    			return $this->redirect()->toRoute('dashboard');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('dashboard', array(
    				'action' => 'add'
    		));
    	}
    	
    	// Get the Dashboard with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$dashboard = $this->getDashboardTable()->getDashboard($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('dashboard', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new DashboardForm();
    	$form->bind($dashboard);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($dashboard->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getDashboardTable()->saveDashboard($dashboard);
    	
    			// Redirect to list of dashboards
    			return $this->redirect()->toRoute('dashboard');
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);    	
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('dashboard');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getDashboardTable()->deleteDashboard($id);
    		}
    	
    		// Redirect to list of dashboards
    		return $this->redirect()->toRoute('dashboard');
    	}
    	
    	return array(
    			'id'    => $id,
    			'dashboard' => $this->getDashboardTable()->getDashboard($id)
    	);    	
    }
    
    public function getDashboardTable()
    {
    	if (!$this->dashboardTable) {
    		$sm = $this->getServiceLocator();
    		$this->dashboardTable = $sm->get('Dashboard\Model\DashboardTable');
    	}
    	return $this->dashboardTable;
    }    
}