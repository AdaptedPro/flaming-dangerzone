<?php
namespace Automate;

use Zend\Mvc\ModuleRouteListener;
use Automate\Model\Automate;
use Automate\Model\AutomateTable;
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
    					'Automate\Model\AutomateTable' =>  function($sm) {
    						$tableGateway = $sm->get('AutomateTableGateway');
    						$table = new AutomateTable($tableGateway);
    						return $table;
    					},
    					'AutomateTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Automate());
    						return new TableGateway('automate', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }    
}