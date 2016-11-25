<?php 

namespace Model;

use Config\Connection;

/**
 * Class responsible for cominication with database
 * 
 */
abstract class Model extends Connection
{
    /**
     * Table of query
     *
     * @var string
     */
	protected $table;
    
    /**
     * Primary of table
     *
     * @var int
     */
	protected $primary_key;
    
    /**
     * Other columns of table
     *
     * @var array
     */
	protected $fields = [];
    
    /**
     * Save date insert and update in table
     *
     * @var bool
     */
	protected $timestemp = true;
    
    /**
     * Object of connection with database
     *
     * @var objecto
     */
	private $pdo;
    
    
    /**
     * Select of query
     *
     * @var string
     */
	private $_select = 'SELECT * ';
    
    /**
     * Join of query
     *
     * @var string
     */
	private $_join;
    
    /**
     * Where of query
     *
     * @var string
     */
	private $_where;
    
    /**
     * Or of query
     *
     * @var string
     */
	private $_or_where;
    
    /**
     * Like of query
     *
     * @var string
     */
	private $_like;
    
    /**
     * Limit of query
     *
     * @var string
     */
	private $_limit;
    
    /**
     * Order by of query
     *
     * @var string
     */
	private $_order_by;
    
    
    /**
     * Query built
     *
     * @var string
     */
	protected $_query;

    /**
     * Construct of class for connection with database
     * 
	 * @return void
     */	
	public function __construct()
	{
		$this->pdo = parent::connect();
	}


    /**
     * Destroy the connection with database
     * 
	 * @return void
     */	
	private function desconectar()
    {
        $this->disconnect($this->pdo);
    }
    
    
    /**
     * Function that stores the table of query
     * 
     * @param string $table
     * 
	 * @return $this
     */	
	protected function table($table)
    {
        $this->table = $table;
        return $this;
    }
    
    
    /**
     * Function that stores the content of query
     * 
     * @param string $content
     * 
	 * @return $this
     */	
	protected function select($content)
    {
        $this->_select = 'SELECT ' . $content;
        return $this;
    }
    
    
    /**
     * Function that get all registers of table
     * 
	 * @return $this
     */	
	protected static function all()
    {   
        $instance = new static();
        
        return $instance->get();
    }
    
    
    /**
     * Function that stores the where of query
     * 
     * @param string $param2
     * @param string $param1
     * 
	 * @return $this
     */	
	protected function where($param1, $param2 = false)
    {
        if ($param2)
            $this->_where .= ' WHERE ' . $param1 . ' = ' . $param2;
        
        if (is_array($param1))
            $this->_where .= ' WHERE ' . $param1[0] . ' = ' . $param1[1];
        
        return $this;
    }


    /**
     * Function that stores the OR of where
     * 
     * @param string $param2
     * @param string $param1
     * 
	 * @return $this
     */	
	protected function or_where($param1, $param2 = false)
    {
        if ($param2)
            $this->_or_where .= ' OR ' . $param1 . ' = ' . $param2;
        
        if (is_array($param1))
            $this->_or_where .= ' OR ' . $param1[0] . ' = ' . $param1[1];;
            
        return $this;
    }


    /**
     * Function that stores the order by of query
     * 
     * @param string $order_by
     * 
	 * @return $this
     */	
	protected function order_by($order_by)
    {
        $this->_order_by .= ' ORDER BY ' . $order_by;
        return $this;
    }


    /**
     * Function that stores the limit of query
     * 
     * @param string $limit
     * 
	 * @return $this
     */	
	protected function limit($limit)
    {
        $this->_limit .= ' LIMIT ' . $limit;
        return $this;
    }


    /**
     * Function that stores the join of query
     * 
     * @param string $table
     * @param string $relation
     * @param string $type
     * 
	 * @return $this
     */	
	protected function join($table, $relation, $type)
    {
        if (is_array($join))
            $this->_join = ' ' . $type . ' join ' . $table . ' ON ' . $relation ;
        
        return $this;
    }
    
    
    /**
     * Function that stores the like of query
     * 
     * @param string $field
     * @param string $like
     * 
	 * @return $this
     */	
	protected function like($field, $like)
    {
        if ($this->_where)
            $this->_like = ' AND ' . $field . ' LIKE "' . $like . '"';
        
        else
            $this->_like = ' WHERE ' . $field . ' LIKE "' . $like . '"';
            
        return $this;
    }


    /**
     * Function that get the first result of query unknown
     * 
     * @param object PDO $return_type
     * 
	 * @return $this
     */	
	protected function first($return_type = null)
    {   
        $this->getQuery();
        
        switch ($return_type) {
            case 'obj':
                $type = \PDO::FETCH_OBJ;
                break;
            
            default:
                $type = \PDO::FETCH_ASSOC;
                break;
        }
        
        $this->_query = $this->_query->fetch($type);
        
        foreach ($this->_query as $key => $value)
            $this->$key = $value;
        
	    return $this;
    }
    
    
    /**
     * Function that returns the amount of registers of query unknown
     * 
	 * @return $this
     */	
	protected function count()
    {
        $this->getQuery();
        
        return (int)$this->_query->rowCount();
    }
    
    
    /**
     * Function that returns the results of query
     * 
     * @param object PDO $return_type
     * 
	 * @return $this
     */	
	protected function get($return_type = 'obj')
    {
        $this->getQuery();
        
        switch ($return_type) {
            case 'obj':
                $type = \PDO::FETCH_OBJ;
                break;
            
            case 'array':
                $type = \PDO::FETCH_ASSOC;
                break;
        }
        
        $this->_query = $this->_query->fetchAll($type);
        
	    return $this->_query;
    }
    
    
    /**
     * Function that performs one query in hand
     * 
     * @param string $query
     * 
	 * @return $this
     */	
	protected function query($query)
    {
        $this->_query = $query;
        return $this;
    }
    
    
    /**
     * Function that uni as partes of query
     * 
	 * @return $this
     */	
	private function getQuery()
    {
        $this->connect();
        
        if (!$this->_query)
            $this->_query = $this->_select . ' FROM ' . $this->table . $this->_join . $this->_where . $this->_or_where . $this->_like . $this->_limit . $this->_order_by; 
        
        $this->_query = $this->pdo->prepare($this->_query);
	    return $this->_query->execute();
    }
    
    
    /**
     * Function that execute one query (update, insert, delete)
     * 
	 * @return $this
     */	
	protected function execute()
    {
        $this->_query = $this->pdo->prepare($this->_query);
        
        if (!$this->_query->execute())
            return false;
            
        return (int)$this->pdo->lastInsertId();
    }
    
    
    /**
     * Function that do update in one register
     * 
     * @param string $param1
     * @param string $param2(opcional)
     * 
	 * @return $this
     */	
	protected function update($param1, $param2 = false)
    {
        if ($param2)
            $this->query .= ' SET ' . $param1 . ' = ' . $param2;
        
        if (is_array($param1))
            $this->query .= ' SET ' . $param1[0] . ' = ' . $param1[1];;
        
        $query = $this->pdo->prepare('UPDATE ' . $this->query);
        
	    return $query->execute();
    }
    
    
    /**
     * Function that do insert one register
     * 
	 * @return $this
     */	
	protected function save()
    {
        $id = $this->primary_key;
        
        if ($this->$id)    
            $execute = $this->update_save($this->$id);
        
        else
            $execute = $this->insert_save();
        
        if (substr($execute, 0, 6) == 'INSERT')
            $return_id = true;
        
        $execute = $this->pdo->prepare($execute);
        
        if (!$execute->execute())
            return false;
        
        if (!$return_id)
            return true;
        
        return (int)$this->pdo->lastInsertId();
    }
    
    
    /**
     * Function that builds the insert
     * 
	 * @return $this
     */	
	private function insert_save()
    {
        $insert = 'INSERT INTO ' . $this->table . ' (';
        
        $value;
        
        foreach ($this->fields as $field) {
            $insert .= $field . ', ';
            $value  .= $this->$field . '", "';
        }
        
        if ($this->timestemp) {
            $insert .= 'created, updated';
            $value  .=  date('Y-m-d H:i') . '", "' . date('Y-m-d H:i') . '"';
        } else {
            $insert = substr($insert, 0, -2);
            $value  = substr($value, 0, -3);
        }
        
        return $insert . ') VALUES ("' . $value . ')';
    }
    
    
    /**
     * Função que builds the update
     * 
     * @param int $id 
	 * @return $this
     */	
	private function update_save($id)
    {
        $update = 'UPDATE ' . $this->table . ' SET ';
        
        foreach ($this->fields as $field)
            $update .= $field . ' = "' . $this->$field . '", ';
        
        if ($this->timestemp)
            $update  .=  'updated = "' . date('Y-m-d H:i') . '"';
        
        else
            $update  = substr($value, 0, -3);
        
        return $update . ' WHERE ' . $this->primary_key . ' = ' . $id;
    }
    
    
    /**
     * Function that to do delete that one register
     * 
	 * @return $this
     */	
	private function delete()
    {
        $id = $this->primary_key;
        
        if (!$this->_query)
            $delete = $this->pdo->prepare($this->_query);
        
        else
            $delete = 'DELETE ' . $this->table . ' WHERE ' . $this->$id;
        
        $delete = $this->pdo->prepare($delete);
        
        return $delete->execute();
    }
}