<?php

namespace Application\Controller;

use Facebook;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {   	   	
    	return new ViewModel();
    }
    
    public function projectAction()
    {
    	return new ViewModel();
    }    
}
