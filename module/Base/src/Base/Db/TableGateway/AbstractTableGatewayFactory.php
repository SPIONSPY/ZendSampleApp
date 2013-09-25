<?php 

namespace Base\Db\TableGateway;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

/**
 * Constructed factory to set pages during construction.
 */

class AbstractTableGatewayFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {                
        if (!class_exists($requestedName)) {
            
            return false;
        }
        
        if (!is_subclass_of($requestedName,'Base\Db\TableGateway\TableGateway')) {
            
            return false;
        }
        
        if (substr($requestedName,-1 * strlen('Table')) != 'Table') {
            
            return false;
        }
        
        return true;
    }
 
    protected function getRowClass(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        
        $rowClass = substr($requestedName,0,-1 * strlen('Table')); // remove word Table
        $rowClass = '\\' . $rowClass; // absolute path     

        return $rowClass;
    }
    
    protected function getTableName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
                
        $rowClass = $this->getRowClass($serviceLocator, $name, $requestedName);
        $camelCaseToUnderscore = $serviceLocator->get('CamelCaseToUnderscore'); // use this filter because zend one has a bug
        
        // get table name
        
        $tableName = substr(strrchr($rowClass, '\\'), 1); // just name, without namespace
        $tableName = $camelCaseToUnderscore->filter($tableName); // convert to underscore
        
        // get table prefix
        
        $pos = strpos($rowClass, '\\', 1);
        
        if ($pos !== false) {
            
            $tablePrefix = substr($rowClass,1,$pos-1); // get module name
            $tablePrefix = $camelCaseToUnderscore->filter($tablePrefix); // convert module name to underscore
            
            $tableName = $tablePrefix . '__' . $tableName; // use double underscore between prefix and name
        }
               
        return $tableName;
    }
    
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {        
        $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        
        $rowClass = $this->getRowClass($serviceLocator, $name, $requestedName);
        $tableName = $this->getTableName($serviceLocator, $name, $requestedName);
        
        $row = new $rowClass('id', $tableName, $adapter, $serviceLocator);
        
        $resultSetPrototype = new ResultSet();        
        $resultSetPrototype->setArrayObjectPrototype($row);
        
        $features = null;
        // $features = new RowGatewayFeature('id');
        
        $table = new $requestedName($tableName, $adapter, $features, $resultSetPrototype, null, $serviceLocator);
        
        return $table;
    }
}