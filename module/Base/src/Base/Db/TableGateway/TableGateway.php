<?php 

namespace Base\Db\TableGateway;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql;

class TableGateway extends \Zend\Db\TableGateway\TableGateway
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
    
    public function __construct($table, Adapter $adapter, $features = null, ResultSet $resultSetPrototype = null, Sql $sql = null, ServiceLocatorInterface $serviceLocator)
    {            
        $this->serviceLocator = $serviceLocator;
        
        return parent::__construct($table,$adapter,$features,$resultSetPrototype,$sql);
    }
    
    public function getSqlString(Sql\AbstractSql $sql) {
        
        return $this->getSql()->getSqlStringForSqlObject($sql);
    }
    
    public function selectAll()
    {
        $resultSet = $this->select();
    
        return $resultSet;
    }
    
    public function selectById($id)
    {
        if (empty($id)) {
    
            throw new \Exception("Could not search for empty row");
        }
    
        if (!is_numeric($id)) {
    
            throw new \Exception("Could not search for non-numeric row " . $id);
        }
    
        $where = array('id' => $id);
    
        $resultSet = $this->select($where);
        
        $row = $resultSet->current();
    
        if (empty($row)) {
            throw new \Exception("Could not find row $id");
        }
    
        return $row;
    }

    public function deleteById($id)
    {
        if (empty($id)) {
    
            throw new \Exception("Could not delete empty row");
        }
    
        return $this->delete(array('id' => $id));
    }    
}