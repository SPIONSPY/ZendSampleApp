<?php 

namespace Base\Model;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Constructed factory to set pages during construction.
 */

class AbstractTableFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $sm, $name, $requestedName)
    {                
        if (strlen($requestedName) <= strlen('Table')) {
            
            return false;
        }
        
        if (substr($requestedName,-1 * strlen('Table')) != 'Table') {
            
            return false;
        }
        
        return true;
    }
 
    public function createServiceWithName(ServiceLocatorInterface $sm, $name, $requestedName)
    {        
        $tableGateway = $sm->get($requestedName . 'Gateway');
        $table = new $requestedName($tableGateway, $sm);
        return $table;
    }
}