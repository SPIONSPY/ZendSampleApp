<?php

namespace Shop\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;
use File\Service\FileManager;

/**
 * ShopManager service factory
 */

class ShopManagerFactory implements FactoryInterface 
{
    /**
     * Factory method for ShopManager service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ShopManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $config = $serviceLocator->get('Configuration');
        $params = $config['shop_manager'];

        $objectManager = $serviceLocator->get(EntityManager::class);
        
        $service = new ShopManager($params, $objectManager);
        
        return $service;
    }
}