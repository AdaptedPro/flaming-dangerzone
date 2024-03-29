<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Upload\Controller\Upload' => 'Upload\Controller\UploadController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'upload' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/upload[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Upload\Controller\Upload',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'upload' => __DIR__ . '/../view',
        ),
    ),
		
);