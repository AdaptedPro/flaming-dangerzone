<?php
namespace Login;

use Zend\Mvc\ModuleRouteListener;
use Login\Model\Login;
use Login\Model\LoginTable;
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
    					'Login\Model\LoginTable' =>  function($sm) {
    						$tableGateway = $sm->get('LoginTableGateway');
    						$table = new LoginTable($tableGateway);
    						return $table;
    					},
    					'LoginTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Login());
    						return new TableGateway('login', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }    
}