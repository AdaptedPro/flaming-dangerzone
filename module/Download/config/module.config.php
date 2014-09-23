<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Download\Controller\Download' => 'Download\Controller\DownloadController',
        ),
    ),
	
	'router' => array(
			'routes' => array(
					'download' => array(
							'type'    => 'segment',
							'options' => array(
									'route' => '/download[/:action][/:id]',
									'constraints' => array(
											'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     => '[0-9]+',
									),
									'defaults' => array(
											'controller' => 'Download\Controller\Download',
											'action'     => 'index',
									),
							),
					),
			),
	),		
		
    'view_manager' => array(
        'template_path_stack' => array(
            'download' => __DIR__ . '/../view',
        ),
    ),
		
);