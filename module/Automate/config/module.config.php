<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Automate\Controller\Automate' => 'Automate\Controller\AutomateController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'automate' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/automate[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Automate\Controller\Automate',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'automate' => __DIR__ . '/../view',
        ),
    ),
);