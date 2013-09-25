<?php 

namespace Base\Db\RowGateway;

use Zend\ServiceManager\ServiceLocatorInterface;

class RowGateway extends \Zend\Db\RowGateway\RowGateway
{
    /**
     * Service locator
     * Used to get dependent tables
     * @var ServiceLocatorInterface
     */
    
    protected $serviceLocator;
    
    public function getServiceLocator() {
        
        return $this->serviceLocator;
    }
    
    public function __construct($primaryKeyColumn, $table, $adapterOrSql = null, ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    
        return parent::__construct($primaryKeyColumn, $table, $adapterOrSql);
    }
        
    public function __call($method, array $arguments = array())
    {
        if (substr($method,0,3) == 'get') {

            $column = lcfirst(substr($method,3));
            
            // TODO: check if $column is a column in the table
            
            if (isset($this->data[$column])) {
                
                return $this->data[$column];
            }
        }
        else if (substr($method,0,3) == 'set') {
            
            $column = lcfirst(substr($method,3));

            // TODO: check if $arguments[0] isset
            // TODO: check if $column is a column in the table
                        
           $this->data[$column] = $arguments[0];
           
           return true;
        }

        // default behaviour: proxy call to container
        // return parent::__call($method, $arguments);
    }
        
    public function getArrayCopy()
    {
        return $this->data;
        // return get_object_vars($this);
    }
}