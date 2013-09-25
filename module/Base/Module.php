<?php

namespace Base;

use Zend\EventManager\EventInterface as Event;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach('bootstrap', array($this, 'onBootstrap'));
    }    
    
    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        // $sm = $e->getApplication()->getServiceManager();
        // $router = $sm->get('router');
        // $router->getRoutePluginManager()->setInvokableClass('bad','\Base\Mvc\Router\Http\Bad');
    }    
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return array(
    	    'abstract_factories' => array(
    	        'AbstractTableGatewayFactory' => 'Base\Db\TableGateway\AbstractTableGatewayFactory',
    	    ),    	    	
    		'factories' => array(
    			'CamelCaseToUnderscore' =>  function(ServiceLocatorInterface $sm) {    			    
    			    return new Filter\Word\CamelCaseToUnderscore();
    			},
    			'CamelCaseToDash' =>  function(ServiceLocatorInterface $sm) {
    			    return new Filter\Word\CamelCaseToDash();
    			},    			 
    		),
    	);
    }    
}