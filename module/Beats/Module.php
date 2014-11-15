<?php
namespace Beats;

use Zend\Mvc\ModuleRouteListener;
#use Beats\Model\Beats;
#use Beats\Model\BeatsTable;
#use Zend\Db\ResultSet\ResultSet;
#use Zend\Db\TableGateway\TableGateway;

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
    					'Beats\Model\BeatsTable' =>  function($sm) {
    						$tableGateway = $sm->get('BeatsTableGateway');
    						$table = new BeatsTable($tableGateway);
    						return $table;
    					},
    					'BeatsTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Beats());
    						return new TableGateway('project', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    			*/
    	);
    }    
}