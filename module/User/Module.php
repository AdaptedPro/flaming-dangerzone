<?php
namespace User;

use Zend\Mvc\ModuleRouteListener;
use User\Model\TempUser;
use User\Model\User;
use User\Model\UserTable;
use User\Model\TempUserTable;
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
    					'User\Model\UserTable' =>  function($sm) {
    						$tableGateway = $sm->get('UserTableGateway');
    						$table = new UserTable($tableGateway);
    						return $table;
    					},
    					'User\Model\TempUserTable' =>  function($sm) {
    						$tableGateway = $sm->get('TempUserTableGateway');
    						$table = new TempUserTable($tableGateway);
    						return $table;
    					},    					
    					'UserTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new User());
    						return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
    					},
    					'TempUserTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new TempUser());
    						return new TableGateway('tempuser', $dbAdapter, null, $resultSetPrototype);
    					},    					
    			),
    	);
    }    
}