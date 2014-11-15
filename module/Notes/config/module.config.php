<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Notes\Controller\Notes' => 'Notes\Controller\NotesController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'notes' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/notes[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Notes\Controller\Notes',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'notes' => __DIR__ . '/../view',
        ),
    ),
);