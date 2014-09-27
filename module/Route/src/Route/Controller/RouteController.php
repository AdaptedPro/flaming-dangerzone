<?php
namespace Route\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Route\Model\Route;
use Route\Form\RouteForm;

class RouteController extends AbstractActionController
{
	protected $routeTable;
	
    public function indexAction()
    {
         return new ViewModel(array(
             'routes' => $this->getRouteTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
    	$form = new RouteForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$route = new Route();
    		$form->setInputFilter($route->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$route->exchangeArray($form->getData());
    			$this->getRouteTable()->saveRoute($route);
    	
    			// Redirect to list of routes
    			return $this->redirect()->toRoute('route');
    		}
    	}
    	return array('form' => $form);    	
    }

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$user_id = isset($_SESSION['auth_user']['id'])?$_SESSION['auth_user']['id']:$this->redirect()->toRoute('home');
    	if (!$id) {
    		return $this->redirect()->toRoute('route', array(
    				'action' => 'add',
    		));
    	}
    	
    	// Get the Route with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$route = $this->getRouteTable()->getRoute($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('route', array(
    				'action' => 'index'
    		));
    	}
    	
    	$form  = new RouteForm();
    	$form->bind($route);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($route->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$this->getRouteTable()->saveRoute($route);
    	
    			// Redirect to list of routes
    			return $this->redirect()->toRoute('route');
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    			'userid' => $user_id,
    	);    	
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('route');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getRouteTable()->deleteRoute($id);
    		}
    	
    		return $this->redirect()->toRoute('route');
    	}
    	
    	return array(
    			'id'    => $id,
    			'route' => $this->getRouteTable()->getRoute($id)
    	);    	
    }
    
    public function getRouteTable()
    {
    	if (!$this->routeTable) {
    		$sm = $this->getServiceLocator();
    		$this->routeTable = $sm->get('Route\Model\RouteTable');
    	}
    	return $this->routeTable;
    }    
}