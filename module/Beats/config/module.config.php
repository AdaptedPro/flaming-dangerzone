<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Beats\Controller\Beats' => 'Beats\Controller\BeatsController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'beats' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/beats[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Beats\Controller\Beats',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'beats' => __DIR__ . '/../view',
        ),
    ),
);