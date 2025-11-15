<?php 
class Messages_model extends Base_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_messages_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_MSG, $criteria);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_inbox_list_paging_by_criteria($criteria = array()) {
        $limit = '';
        $whereCondition = " ( (receiver_dele_flag != 'True') || (ISNULL(receiver_dele_flag)) )";
        if(isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            $whereCondition .= " AND receiver_id='" . $criteria['user_id'] . "'";
        }
        /* if(isset($criteria['caste']) && !empty($criteria['caste'])) {
            if(!empty($whereCondition)) {
                $whereCondition .= ' AND ';
            }
            $whereCondition .= "caste='" . $criteria['caste'] . "'";
        } */
        
        $order_by = " ORDER BY srno DESC";
        if(isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT ". $criteria['offset'] .", ".$criteria['limit'];
        }
        $sql = "SELECT *
				FROM " . EVENT_TBL_MSG . "
				WHERE " . $whereCondition . $order_by . $limit;
        
        //echo $sql;//exit;
        return $this->get_list_by_query($sql, true);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_outbox_list_paging_by_criteria($criteria = array()) {
        $limit = '';
        $whereCondition = " ( (sender_dele_flag != 'True') || (ISNULL(sender_dele_flag)) )";
        if(isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            $whereCondition .= " AND sender_id='" . $criteria['user_id'] . "'";
        }
        /* if(isset($criteria['caste']) && !empty($criteria['caste'])) {
         if(!empty($whereCondition)) {
         $whereCondition .= ' AND ';
         }
         $whereCondition .= "caste='" . $criteria['caste'] . "'";
         } */
        
        $order_by = " ORDER BY srno DESC";
        if(isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT ". $criteria['offset'] .", ".$criteria['limit'];
        }
        $sql = "SELECT *
				FROM " . EVENT_TBL_MSG . "
				WHERE " . $whereCondition . $order_by . $limit;
        
        //echo $sql;//exit;
        return $this->get_list_by_query($sql, true);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_messages_list_by_criteria($criteria = array(), $order_by = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_MSG, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function save_messages_details($criteria = array()) {
        $criteria['msg_time'] = date('h:i:s a');
        $criteria['msg_date'] = date('Y-m-d');
        //Save user data
        $id = $this->save(EVENT_TBL_MSG, $criteria);
        
        return $id;
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_messages_details_criteria($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_MSG, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_messages_detail_by_query($msg_id) {
        $sql = "UPDATE " . EVENT_TBL_MSG ." SET read_flag='True' WHERE (  (msg_id = '$msg_id') AND (sender_id != '')  )";
        $this->db->query($sql);
    }
    
    public function get_data($user_id) {
        $sql = "SELECT * FROM " . EVENT_TBL_MSG ."  WHERE (  ((read_flag != 'True') OR (ISNULL(read_flag) ) ) AND (msg_id != '') AND (sender_id != '') AND (receiver_id='$user_id') AND ( (receiver_dele_flag != 'True') || (ISNULL(receiver_dele_flag)) ) )";
        return $this->get_list_by_query($sql);
    }
    
    public function delete_data() {
        $sql = "DELETE FROM " . EVENT_TBL_MSG ." WHERE ( (receiver_dele_flag = 'True') AND ( sender_dele_flag = 'True') )";
        $this->db->query($sql);
    }
}