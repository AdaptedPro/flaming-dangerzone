<?php
namespace Upload;

use Zend\Mvc\ModuleRouteListener;
use Upload\Model\Upload;
use Upload\Model\UploadTable;
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
    					'Upload\Model\UploadTable' =>  function($sm) {
    						$tableGateway = $sm->get('UploadTableGateway');
    						$table = new UploadTable($tableGateway);
    						return $table;
    					},
    					'UploadTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Upload());
    						return new TableGateway('upload', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }    
}