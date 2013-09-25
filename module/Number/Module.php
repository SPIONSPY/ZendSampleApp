<?php

namespace Number;

use Number\View\Helper\IntegerToRomanNumeral;
use Number\View\Helper\RomanNumeralToInteger;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'integerToRomanNumeral' => function ($serviceManager) {
                    
                    $serviceLocator = $serviceManager->getServiceLocator();                    
                    $numberConverter = $serviceLocator->get('NumberConverter');
                    $viewHelper = new IntegerToRomanNumeral($numberConverter);
                        
                    return $viewHelper;
                },
                'romanNumeralToInteger' => function ($serviceManager) {
                
                    $serviceLocator = $serviceManager->getServiceLocator();
                    $numberConverter = $serviceLocator->get('NumberConverter');
                    $viewHelper = new RomanNumeralToInteger($numberConverter);
                
                    return $viewHelper;
                },                
            ),
        );
    }    
}