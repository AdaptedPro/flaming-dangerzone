<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Springer\Controller\Springer' => 'Springer\Controller\SpringerController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'springer' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/springer[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Springer\Controller\Springer',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'springer' => __DIR__ . '/../view',
        ),
    ),
);