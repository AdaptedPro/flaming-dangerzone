<?php
namespace Download;

use Zend\Mvc\ModuleRouteListener;
use Download\Model\Download;
use Download\Model\DownloadTable;
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
    					'Download\Model\DownloadTable' =>  function($sm) {
    						$tableGateway = $sm->get('DownloadTableGateway');
    						$table = new DownloadTable($tableGateway);
    						return $table;
    					},
//     					'DownloadTableGateway' => function ($sm) {
//     						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//     						$resultSetPrototype = new ResultSet();
//     						$resultSetPrototype->setArrayObjectPrototype(new Download());
//     						return new TableGateway('download', $dbAdapter, null, $resultSetPrototype);
//     					},
    			),
    	);
    }    
}