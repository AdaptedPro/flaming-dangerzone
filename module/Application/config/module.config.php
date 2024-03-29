<?php

use Zend\Db\Adapter\Adapter;

$start_controller = isset($_SESSION['auth_user']) ? 'Dashboard\Controller\Dashboard' :'Application\Controller\Index';
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => $start_controller,
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    	'factories' => array(
    		'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
    	),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
	
	'navigation' => array(
			'default' => array(
					array(
							'label' => 'Dashboard',
							'route' => 'home',
					),
					array(
							'uri' => 'http://www.pik2ascii.appspot.com',
							'label' => 'PIK-2-ASCII',
							'class' => 'external',
					),										
					array(
							'label' => 'Springer Notes',
							'route' => 'springer',
					),					
					array(
							'label' => 'Map-it',
							'route' => 'mapit',
					),
					array(
							'label' => 'Cirrus Era',
							'route' => 'cirrusera',
					),																							
					array(
							'label' => 'Projects',
							'route' => 'project',
							'pages' => array(
									array(
											'label' => 'Add',
											'route' => 'project',
											'action' => 'add',
									),
									array(
											'label' => 'Edit',
											'route' => 'project',
											'action' => 'edit',
									),
									array(
											'label' => 'Delete',
											'route' => 'project',
											'action' => 'delete',
									),
							),
					),
			),
	),		
		
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
    	    'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
