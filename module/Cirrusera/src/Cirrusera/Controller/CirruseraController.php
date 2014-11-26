<?php
namespace Cirrusera\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CirruseraController extends AbstractActionController
{
	
    public function indexAction()
    {
         return new ViewModel(array(
             'cirrusera_url' => 'http://young-mesa-6996.herokuapp.com',
         ));
    }
  
}