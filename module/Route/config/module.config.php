<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Route\Controller\Route' => 'Route\Controller\RouteController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'route' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/route[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Route\Controller\Route',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'route' => __DIR__ . '/../view',
        ),
    ),
);