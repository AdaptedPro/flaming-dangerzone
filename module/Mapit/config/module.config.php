<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mapit\Controller\Mapit' => 'Mapit\Controller\MapitController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'mapit' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/mapit[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Mapit\Controller\Mapit',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'mapit' => __DIR__ . '/../view',
        ),
    ),
);