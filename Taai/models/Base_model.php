<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class define all common function that will be reuse while coding.
 * 
 * @author Sagar Patil <sagarpatil2112@gmail.com>
 * @package CodeIgniter
 * @subpackage Model
 * @category Model
 * @access Public
 * @version 1.0
 * @copyright Copyright (c) 2021
 */
class Base_model extends CI_Model {
	/**
	 * This function load the database when class will be initiated
	 */
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * This function return the all fields list by criteria 
	 * @param string $tableName
	 * @param array $criteria
	 * @param string $isObjectToArray
	 * @return mixed
	 */
	public function get_list_by_criteria($tableName = '', $criteria = array(), $order_by = array(), $isObjectToArray = true) {
	    if(!empty($order_by)) {
	        $this->db->order_by($order_by['field'], $order_by['order']);
	    }
		if($isObjectToArray) {
		    $data = $this->db->get_where($tableName, $criteria)->result_array();
		    //Print the query
		    //echo '#'.$this->db->last_query(FALSE);
		    return $data;
		} else {
		    $data = $this->db->get_where($tableName, $criteria)->result();
		    //Print the query
		    //echo '#'.$this->db->last_query(FALSE);
		    return $data;
		}
	}
	
	/**
	 * This function return the all fields detail by criteria
	 * @param string $tableName
	 * @param array $criteria
	 * @param string $isObjectToArray
	 * @return mixed
	 */
	public function get_detail_by_criteria($tableName = '', $criteria = array(), $isObjectToArray = true) {
		if($isObjectToArray) {
		    $data = $this->db->get_where($tableName, $criteria)->row_array();
		    //Print the query
		    //echo '#'.$this->db->last_query(FALSE);
		    return $data;
		} else {
		    $data = $this->db->get_where($tableName, $criteria)->row();
		    //Print the query
		    //echo '#'.$this->db->last_query(FALSE);
			return $data;
		}
	}
	
	// Return all records in the table
	/**
	 * This function return the all record contain in database table.
	 * @param string $tableName Holds the name of database table.
	 * @param boolean $isObjectToArray Holds the TRUE/FALSE value. If it is TRUE it return result in an array format or if it is FALSE it return result in stdClass Object format
	 * 
	 * @return mixed[] Return result either array or object format. Default return result is Object format.
	 */
	public function get_all($tableName, $isObjectToArray = true) {
		$allRecordList = array();
	 	$object = $this->db->get($tableName);
	 	if($object->num_rows() > 0) {
	 		if($isObjectToArray) {
	 			$allRecordList = $object->result_array();
	 		} else {
	 			$allRecordList = $object->result();
	 		}
	 	}
	 	
	 	//Print the query
	 	//echo $this->db->last_query(FALSE);
	 	
	 	return $allRecordList;
	}
	
	/**
	 * This function insert data into database table
	 *
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $collection Holds the data in array format which is to be inserted in a batch
	 *
	 * @return integer Return last inserted Id
	 */
	public function save($tableName, $collection) {
		$this->db->insert($tableName, $collection);
		//Print the query
		//echo $this->db->last_query(FALSE);
		return $this->db->insert_id();//$this->db->affected_rows()  
	}

	/**
	 * This function update the database table
	 *
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $collection Holds the data in array format which is to be updated
	 * @param mixed[] $condition Holds the condition in field=>value (key/value) pair.
	 *
	 * @return mixed[] Return the updated data
	 */
	public function update($tableName, $collection, $condition) {
		return $this->db->update($tableName, $collection, $condition);
		//Print the query
		//echo $this->db->last_query(FALSE);exit;
		//return $this->db->affected_rows()
	}

	/**
	 * This function permanently delete record from the database table
	 *
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $condition Holds the condition in field=>value (key/value) pair.
	 * 
	 * @method $this->db->delete($tableName, $condition)
	 * @return boolean - Return TRUE if delete operation success. It would only return FALSE if it COULDN’T delete the row.
	 * 
	 * @method $this->db->affected_rows()
	 * @return boolean - Which is return number.
	 */
	public function delete($tableName, $condition) {
		 return $this->db->delete($tableName, $condition);
		 //Print the query
		 //echo $this->db->last_query(FALSE);
		 //return $this->db->affected_rows();
	}
    
    /**
     * This function return the single record contain in query result
     * 
     * @param string $sql Holds the query
     * @param boolean $isObjectToArray Holds the TRUE/FALSE value. If it is TRUE it return result in an array format or if it is FALSE it return result in stdClass Object format
     * 
     * @return mixed[] Return the single detail array
     */
	function get_detail_by_query($sql, $isObjectToArray = true){
		$query = $this->db->query($sql);
		$result = array();
		if($query->num_rows() > 0) {
			if($isObjectToArray) {
				$result = $query->row_array();
			} else {
				$result = $query->row();
			}
		}
		
		return $result;
	}
    
    /**
     * This function return the list of query result
     * 
     * @param string $sql Holds the query
     * @param boolean $isObjectToArray Holds the TRUE/FALSE value. If it is TRUE it return result in an array format or if it is FALSE it return result in stdClass Object format
     * 
     * @return mixed[] Return the list array
     */
	function get_list_by_query($sql, $isObjectToArray = true){
		$query = $this->db->query($sql);
		$result = array();
		
		if($isObjectToArray) {
			$result = $query->result_array();
		} else {
			$result = $query->result();
		}
		
		return $result;
	}
	
	/**
	 * This function return the list of record by condition.
	 * 
	 * @param mixed[] $fields Holds the either field array or just '*' symbol.
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $condition Holds the condition in field=>value (key/value) pair.
	 * @param boolean $isObjectToArray Holds the TRUE/FALSE value. If it is TRUE it return result in an array format or if it is FALSE it return result in stdClass Object format
	 * @param mixed[]/string $orderField Holds the either only field array or only one field name.
	 * @param string $orderType Holds the value of either ASC or DESC to sort record.
	 * 
	 * @return mixed[] Return result either array or object format. Default return result is Object format
	 */
	public function get_list_by_condition($fields, $tableName, $condition, $isObjectToArray = false, $orderField='', $orderType='DESC') {
		if(!empty($orderField) && !empty($orderType)) {
			if(is_array($orderField)) {
				$orderField = implode(', ', $orderField);
			}
			$query = $this->db->select($fields)->where($condition)->order_by($orderField, $orderType)->get($tableName);
			if($isObjectToArray) {
				$dataList = $query->result_array();
			} else {
				$dataList = $query->result();
			}
			
			return $dataList;
		}
		$query = $this->db->select($fields)->where($condition)->get($tableName);
		
		if($isObjectToArray) {
			$dataList = $query->result_array();
		} else {
			$dataList = $query->result();
		}
		//Print the query
		//echo $this->db->last_query(FALSE);
		
		return $dataList;
	}
	
	/**
	 * This function return only one record if found in database table by condition
	 * 
	 * @param mixed[] $fields Holds the either field array or just '*' symbol.
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $condition Holds the condition in field=>value (key/value) pair.
	 * @param boolean $isObjectToArray Holds the TRUE/FALSE value. If it is TRUE it return result in an array format or if it is FALSE it return result in stdClass Object format
	 * 
	 * @return mixed[] Return result either array or object format. Default return result is Object format.
	 */
	public function get_single_record($fields, $tableName, $condition, $isObjectToArray = false) {
		$query = $this->db->select($fields)->where($condition)->get($tableName);
		$dataDetail = array();
		if($isObjectToArray) {
			$dataDetail = $query->row_array();
		} else {
			$dataDetail = $query->row();
		}
		//Print the query
		//echo $this->db->last_query(FALSE);
		
		return $dataDetail;
	}
	
	//###############################################################################*/
	/**
	 * This function insert batch data into database table
	 * 
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $collection Holds the data in nested array format which is to be inserted in a batch
	 *
	 * @return integer Return last inserted Id
	 */
	public function saveBatch($tableName, $collection) {
		$this->db->insert_batch($tableName, $collection);
		//Print the query
		//echo $this->db->last_query(FALSE);
		return $this->db->insert_id();
	}
	
	/**
	 * This function return only one field value
	 * 
	 * @param string $tableName Holds the name of database table.
	 * @param mixed[] $condition Holds the condition in field=>value (key/value) pair.
	 * @param string $returnField Holds the name of field which is return the value.
	 * 
	 * @return string/boolean Return the FALSE if result is empty otherwise return value of field
	 */
	public function get_single_field_value($tableName, $condition, $returnField) {
		$result = $this->db->select($returnField)->where($condition)->get($tableName)->result();
		if($result)
			return $result[0]->$returnField;
		else
		   return false;
	}
	
	/**
	 * This function check if the user already logged-in.
	 * 
	 * @return boolean Return TRUE if user already logged-in otherwise return FALSE
	 */
    public function is_session_expire() {
		//Get user data by name
        $currentSession = $this->session->userdata(USER_SESSION_NAME);
        if($currentSession == NULL || empty($currentSession)) {
        	return TRUE;
        } else { 
        	return FALSE; 
       	}
    }
    
    /**
     * This function count all records contain in database table
     * 
     * @param string $tableName Holds the name of database table.
     * 
     * @return integer Return the number of rows in a particular database table
     */
	function count_all($tableName){
		return $this->db->count_all($tableName);
	}
	
	/**
	 * This function permanently delete multiple records from the database table
	 *
	 * @param string $tableName Holds the name of database table.
	 * @param string $attribute Holds the field name
	 * @param mixed[] $inarray Holds the value in array format
	 *
	 * @return boolean Return TRUE if delete operation success. It would only return FALSE if it COULDN’T delete the row.
	 */
	public function MultipleDeleteRecord($tableName, $attribute, $inarray) {
		$this->db->where_in($attribute, $inarray);
		$this->db->delete($tableName);
		//Print the query
		//echo $this->db->last_query(FALSE);
	}

	/**
	 * This function execute the given query and return the data
	 * @param string $table_name
	 * @param string $fields
	 * @param array $criteria
	 * @param string $sql
	 * @return mixed[]
	 */
	/* function get_table_data($table_name = '', $fields = '', $criteria = null, $sql = '', $is_query = true) {
		if(empty($sql)) {
			if(empty($table_name)) {
				return ;
			}
			if(empty($fields)) {
				$fields = '*';
			}
	
			$where = '';
			if(!empty($criteria)) {
				$whereCondition = '';
				if(is_array($criteria)) {
					foreach ($criteria as $field=>$value) {
						$whereCondition .= " `$field`='" . $value . "' AND";
					}
					$whereCondition = trim(trim($whereCondition), 'AND');
				} else {
					$whereCondition = $criteria;
				}
				if(!empty($whereCondition)) {
					$where = ' WHERE ' . $whereCondition;
				}
			}
			$sql = "SELECT $fields FROM $table_name $where";
		}
		//echo $sql;
		
		$data = array();
		if(!empty($sql)) {
			$query = $this->db->query($sql);
			$data = $query->result();
		}
	
		return $data;
	} */
	
	//Reconnect to the database
	public function reconnect_database() {
		$this->db->reconnect();
	}
		
	//check duplicate
	public function check_duplicate($tableName,$condition){
		$query = $this->db->get_where($tableName,$condition);	
		if($query->num_rows()==1){
			return true;
		}else{
			return FALSE;
		}
	}
	
	//Get max order number Function:
	public function get_max_ordern_no($fields,$condition,$tableName){
		$res= $this->db->select_max($fields)->where($condition)->get($tableName)->result();
		return $res[0]->$fields;
	}
		
	/**
	 * This function is used to get unique number using current datetime
	 *
	 * @return string Return the unique string
	 */
	public function generate_random_number($len = 6) {
		$base = '1234567890';
		$max = strlen($base) - 1;
		$uniqueNumber = '';
		while (strlen($uniqueNumber) < $len) {
			$uniqueNumber .= $base[mt_rand(0, $max)];
		}
		return $uniqueNumber;
	}
}
?>