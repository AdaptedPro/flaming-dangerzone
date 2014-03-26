<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Rover\Controller\Rover' => 'Rover\Controller\RoverController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'rover' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/rover[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Rover\Controller\Rover',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'rover' => __DIR__ . '/../view',
        ),
    ),
);