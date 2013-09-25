<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
        'driver'         => 'Pdo',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
            ),
        ),
    ),    
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($serviceManager) {

            	$dbParams = $serviceManager->get('config')['db'];
            	
            	if (!isset($dbParams['dsn'])) {            	    
            	    $dbParams['dsn'] = 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'];
            	}
            	            	
                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter($dbParams);

                $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler);
                
                if (isset($dbParams['options']) && is_array($dbParams['options'])) {
                    $options = $dbParams['options'];
                } else {
                    $options = array();
                }
                
                $adapter->injectProfilingStatementPrototype($options);
                
                return $adapter;
            },
        ),
    ),
);
