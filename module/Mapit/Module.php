<?php
namespace Mapit;

use Zend\Mvc\ModuleRouteListener;
use Mapit\Model\Mapit;
use Mapit\Model\MapitTable;
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
    					'Route\Model\RouteTable' =>  function($sm) {
    						$tableGateway = $sm->get('RouteTableGateway');
    						$table = new RouteTable($tableGateway);
    						return $table;
    					},
    					'RouteTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Route());
    						return new TableGateway('route', $dbAdapter, null, $resultSetPrototype);
    					},
    			),   			
    	);
    }    
}