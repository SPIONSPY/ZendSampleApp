<?php 

namespace Base\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\ServiceManager\ServiceLocatorInterface;

class Table
{
    /**
     * Db table
     * @var TableGateway
     */
    
    protected $tableGateway;

    /**
     * Service locator
     * @var ServiceLocatorInterface
     */
    
    protected $serviceLocator;
     
    /**
     * 
     * @param TableGateway $tableGateway
     * @param ServiceLocatorInterface $sm
     */
    
    public function __construct(TableGateway $tableGateway, ServiceLocatorInterface $sm = null)
    {
        $this->tableGateway = $tableGateway;
        $this->serviceLocator = $sm;        
    }
    
    /**
     * Db table name
     */
    
    public function getTable() 
    {
        return $this->tableGateway->getTable();    
    }
    
    public function getSql()
    {
        return $this->tableGateway->getSql();
    }
    
    /**
     * @return Zend\Db\Sql\Select
     */
    
    public function createSqlSelect() {

        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql\Sql($adapter);
        $select = $sql->select();
        
        return $select;
    }
    
    public function executeSqlSelect(Sql\Select $select) {
        
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql\Sql($adapter);
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }
    
    public function findAll()
    {
        $resultSet = $this->tableGateway->select();
    
        return $resultSet;
    }
    
    public function findById($id)
    {
        if (empty($id)) {
    
            throw new \Exception("Could not search for empty row");
        }
    
        if (!is_numeric($id)) {
    
            throw new \Exception("Could not search for non-numeric row " . $id);
        }
    
        $where = array('id' => $id);
    
        $rowset = $this->tableGateway->select($where);
        $row = $rowset->current();
    
        if (empty($row)) {
            throw new \Exception("Could not find row $id");
        }
    
        return $row;
    }    
}