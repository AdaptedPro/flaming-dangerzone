<?php
namespace Mapit\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Route\Model\Route;
use Route\Model\RouteMapper;

class MapitController extends AbstractActionController
{
	protected $routeTable;
	protected $googleMapsKey;
		
    public function indexAction()
    {
    	$googleMaps_info      = $this->getGoogleMapsInfo();
    	$this->googleMapsKey  = $googleMaps_info['api_key'];
    	$user_id              = isset($_SESSION['auth_user']['id'])?$_SESSION['auth_user']['id']:$this->redirect()->toRoute('home');
    	$saved_routes         = $this->buildSaveRoutes($user_id);
    	
    	return new ViewModel(array(
             'api_key'      => $this->googleMapsKey,
    		 'user_id'      => $user_id,
    		 'saved_routes' => $saved_routes,		
         ));
    }
    
    public function ajaxAction()
    {
    	$result = "";
    	$request = $this->getRequest();
	    if ($request->isXmlHttpRequest()){
	    	$route = new Route();
	    	$data = $request->getPost();  	
	    	$errors_count = count($this->ajaxRouteValidation($data));
	    	if ($errors_count == 0) {
    	    	$route->exchangeArray($data);
	    		$this->getRouteTable()->saveRoute($route);
	    		$result = new JsonModel(array( 'success'=>true, ));
	    	} else {
	    		$result = new JsonModel(array( 'success'=>false, ));
	    	}	
	    } else {
	    	$result = $this->redirect()->toRoute('mapit');
	    }
    	return $result;
    }
    
    private function ajaxRouteValidation($DATA)
    {
    	$isValid = array();
    	foreach ($DATA as $key => $val) {
    		if ($key != 'id' && $val == "") {
    			$isValid[]= "'{$key}' cannot be blank!";
    		}   		
    	}    	
    	return $isValid;
    }
    
    private function getGoogleMapsInfo()
    {
    	$serviceLocator       = $this->getServiceLocator();
    	$config               = $serviceLocator->get('config');
    	$this->googleMapsKey  = $config['google_maps'];
    	return $this->googleMapsKey;
    }    

    private function getRouteTable()
    {
    	if (!$this->routeTable) {
    		$sm = $this->getServiceLocator();
    		$this->routeTable = $sm->get('Route\Model\RouteTable');
    	}
    	return $this->routeTable;
    }

    private function buildSaveRoutes($id)
    {
    	$user_saved_routes =  $this->getRouteTable()->get_routes_by_user_id($id);
    	if (!empty($user_saved_routes)) {
    		$num = count($user_saved_routes);
    		$output = "<div class='btn-group'><button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown'>
    		           Saved Routes&nbsp;<span class='caret'></span>
    		           </button>";
    		$output .= "<ul class='dropdown-menu' role='menu'>";
	    	foreach ($user_saved_routes as $route) {
	    		$output .= "<li>
	    		                <a data-rid='{$route->id}'>
	    		                    <strong>{$route->route_name}</strong><br>
	    		                    <strong>From:</strong> {$route->origin}<br>
	    		                    <strong>To:</strong> {$route->destination}
	    		                </a>
	    		            </li> \n";
	    	}
	    	$output .= "</ul></div> \n";
    	} else {
    		$output = "You have no routes saved.";
    	}
    	return $output;		
    }
}