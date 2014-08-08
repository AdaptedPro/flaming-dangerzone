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
    			/*
    			'factories' => array(
    					'Mapit\Model\MapitTable' =>  function($sm) {
    						$tableGateway = $sm->get('MapitTableGateway');
    						$table = new MapitTable($tableGateway);
    						return $table;
    					},
    					'MapitTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Mapit());
    						return new TableGateway('project', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    			*/
    	);
    }    
}