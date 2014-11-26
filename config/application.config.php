<?php
$env = getenv('APPLICATION_ENV')?: 'production';

// Use the $env value to determine which modules to load
$modules = array(
		'Application','Dashboard','Mapit','Route','Project','User','Rover','Notes','Beats', 'Cirrusera'
);
if ($env == 'development') {	
	#$modules[] = 'ZendDeveloperTools';
}

return array(
		'modules' => $modules,
		'module_listener_options' => array(
				'module_paths' => array(
						'./module',
						'./vendor',
				),
				'config_glob_paths' => array(
    				sprintf('config/autoload/{,*.}{global,%s,local}.php', $env)
				),
				'config_cache_enabled' => ($env == 'production'),
				'config_cache_key' => 'app_config',
				'module_map_cache_enabled' => ($env == 'production'),
				'module_map_cache_key' => 'module_map',
				'cache_dir' => 'data/cache/',
				'check_dependencies' => ($env != 'production'),
		),
				
);
