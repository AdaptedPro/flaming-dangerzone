<?php

namespace Application\Controller;

use Facebook;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {   	   	   	
    	$query = 'SELECT * FROM `pages`';
    	return new ViewModel(array(
    			'users'   => $this->get_menu($query),
    	));    	
    }

    public function downloadAction()
    {
    	
    }
    
    private function get_menu($sql) 
    {
    	$serviceLocator = $this->getServiceLocator();
    	$config         = $serviceLocator->get('config');
    	$configArray    = $config['db'];
    	$adapter        = new Adapter($configArray);
    	$statement      = $adapter->query($sql);    	
    	$records        = $statement->execute();
    	if ($records != false) {
    		foreach ($records as $index => $value) {
    			$formattedRecords[$index] = $value;
    		}
    		return $formattedRecords;
    	} else {
    		$error = die($query."<br>Line: ". __LINE__ ."<br>File: ". __FILE__ ."<br>Function: ". __FUNCTION__ ."()" );
    		return $error;
    	}    	
    }
}
