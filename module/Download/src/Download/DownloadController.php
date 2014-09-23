<?php
namespace Download\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class DownloadController extends AbstractActionController
{
	
    public function indexAction()
    {
    	return new ViewModel(array(

         ));
    } 
}