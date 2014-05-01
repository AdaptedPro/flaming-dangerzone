<?php
namespace Search;

use Zend\Mvc\ModuleRouteListener;
use Search\Model\Search;
use Search\Model\SearchTable;
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
//     					'Search\Model\SearchTable' =>  function($sm) {
//     						$tableGateway = $sm->get('SearchTableGateway');
//     						$table = new SearchTable($tableGateway);
//     						return $table;
//     					},
//     					'SearchTableGateway' => function ($sm) {
//     						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//     						$resultSetPrototype = new ResultSet();
//     						$resultSetPrototype->setArrayObjectPrototype(new Search());
//     						return new TableGateway('search', $dbAdapter, null, $resultSetPrototype);
//     					},
    			),
    	);
    }    
}