<?php
namespace Rover;

use Zend\Mvc\ModuleRouteListener;
use Rover\Model\Rover;
use Rover\Model\RoverTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
		
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Rover\Model\RoverTable' =>  function($sm) {
    						$tableGateway = $sm->get('RoverTableGateway');
    						$table = new RoverTable($tableGateway);
    						return $table;
    					},
    					'RoverTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Rover());
    						return new TableGateway('rover', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }    
}