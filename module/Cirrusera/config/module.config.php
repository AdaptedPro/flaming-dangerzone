<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Cirrusera\Controller\Cirrusera' => 'Cirrusera\Controller\CirruseraController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'cirrusera' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/cirrusera[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Cirrusera\Controller\Cirrusera',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'cirrusera' => __DIR__ . '/../view',
        ),
    ),
);