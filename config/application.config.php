<?php
return array(
    'modules' => array(
        'ZendDeveloperTools',
    	'BjyProfiler',
        'DoctrineModule',
        'DoctrineORMModule',
        'Base',
        'WebinoImageThumb',
        'AssetManager',        
        'TwitterBootstrap',
        'Number',
        'Application',
        'Shop',        
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php'),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
