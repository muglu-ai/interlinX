<?php 
class Meetings_model extends Base_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_meetings_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_GLBL_MEETING, $criteria);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_meetings_list_paging_by_criteria($criteria = array()) {
        $limit = $where = $whereCondition = ''; 
        $whereCondition = "";
        if(isset($criteria['sender_user_id']) && !empty($criteria['sender_user_id'])) {
            $whereCondition = "sender_user_id='" . $criteria['sender_user_id'] . "'";
        }
        if(isset($criteria['receiver_user_id']) && !empty($criteria['receiver_user_id'])) {
            $whereCondition = "receiver_user_id='" . $criteria['receiver_user_id'] . "'";
        }
        if(isset($criteria['tej_data']) && !empty($criteria['tej_data'])) {
            $whereCondition = " (sender_user_id='" . $criteria['tej_sender_user_id'] . "' OR receiver_user_id='" . $criteria['tej_receiver_user_id'] . "') AND status='" . $criteria['status'] . "'";
        }
        /* if(isset($criteria['caste']) && !empty($criteria['caste'])) {
            if(!empty($whereCondition)) {
                $whereCondition .= ' AND ';
            }
            $whereCondition .= "caste='" . $criteria['caste'] . "'";
        } */
        $order_by = " ORDER BY srno DESC";
        if(!empty($whereCondition)) {
            $where = " WHERE " . $whereCondition;
        }
        if(isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT ". $criteria['offset'] .", ".$criteria['limit'];
        }
        $sql = "SELECT *
				FROM " . EVENT_TBL_GLBL_MEETING . "
				" . $where . $order_by . $limit;
        
        //echo $sql;//exit;
        return $this->get_list_by_query($sql, true);
    }
    
    /**
     * Count meetings by criteria without loading full list
     * @param array $criteria
     * @return int
     */
    public function get_meetings_count_by_criteria($criteria = array()) {
        $where = $whereCondition = ""; 
        if(isset($criteria['sender_user_id']) && !empty($criteria['sender_user_id'])) {
            $whereCondition = "sender_user_id='" . $criteria['sender_user_id'] . "'";
        }
        if(isset($criteria['receiver_user_id']) && !empty($criteria['receiver_user_id'])) {
            $whereCondition = "receiver_user_id='" . $criteria['receiver_user_id'] . "'";
        }
        if(isset($criteria['tej_data']) && !empty($criteria['tej_data'])) {
            $whereCondition = " (sender_user_id='" . $criteria['tej_sender_user_id'] . "' OR receiver_user_id='" . $criteria['tej_receiver_user_id'] . "') AND status='" . $criteria['status'] . "'";
        }
        if(isset($criteria['status']) && !empty($criteria['status']) && empty($criteria['tej_data'])) {
            if(!empty($whereCondition)) {
                $whereCondition .= " AND ";
            }
            $whereCondition .= "status='" . $criteria['status'] . "'";
        }
        if(!empty($whereCondition)) {
            $where = " WHERE " . $whereCondition;
        }
        $sql = "SELECT COUNT(*) AS cnt FROM " . EVENT_TBL_GLBL_MEETING . " " . $where;
        $row = $this->get_detail_by_query($sql, true);
        return isset($row['cnt']) ? (int)$row['cnt'] : 0;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_meetings_list_by_criteria($criteria = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_GLBL_MEETING, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function save_meetings_details($criteria = array()) {
        $criteria['req_time'] = date('h:i:s a');
        $criteria['req_date'] = date('Y-m-d');
        //Save user data
        $id = $this->save(EVENT_TBL_GLBL_MEETING, $criteria);
        
        return $id;
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_meetings_details($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_GLBL_MEETING, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_schedule_details($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_ALL_USR_SHDL, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_schedule_list_by_criteria($criteria = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_ALL_USR_SHDL, $criteria);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_schedule_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_ALL_USR_SHDL, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_all_table_details($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_ALL_TABLE_ALL, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_available_timeslot_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_AVBL_TIME_SLOTS, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function update_available_timeslot_details($collection, $condition) {
        //Save user data
        $id = $this->update(EVENT_TBL_AVBL_TIME_SLOTS, $collection, $condition);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_schedule_list($user_id, $qr_whr_claus) {
        $sql = "SELECT * FROM " . EVENT_TBL_ALL_USR_SHDL . " WHERE (receiver_id = '$user_id') and (sender_id != '$user_id') and (status = 'Accepted')  AND ( $qr_whr_claus )";
        return $this->get_list_by_query($sql);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_free_schedule_list($user_id, $qr_whr_claus) {
        $sql = "SELECT * FROM " . EVENT_TBL_ALL_USR_SHDL . " WHERE ((receiver_id='$user_id') AND ( $qr_whr_claus ) AND ( (receiver_id=sender_id) OR (status !='Accepted') OR (ISNULL(status)) OR (ISNULL(sender_id)) ) )";
        return $this->get_list_by_query($sql);
    }
    public function get_schedule_data1($meeting_date, $meeting_time_start) {
        $sql = "SELECT * FROM " . EVENT_TBL_ALL_TABLE_ALL . " WHERE ( (meeting_date = '$meeting_date') AND (meeting_time_start = '$meeting_time_start') AND ((status != 'Over') OR (ISNULL(status))) ) ";
        return $this->get_list_by_query($sql);
    }
    public function get_schedule_data2($meeting_date, $meeting_time_start, $temp_select_avb_table_no) {
        $sql = "SELECT * FROM " . EVENT_TBL_ALL_TABLE_ALL . " WHERE ( (meeting_date = '$meeting_date') AND (meeting_time_start = '$meeting_time_start') AND (table_no='$temp_select_avb_table_no') ) ";
        return $this->get_detail_by_query($sql);
    }
    public function update_data_all($collection, $meeting_date, $meeting_time_start, $temp_select_avb_table_no) {
        $set = '';
        foreach ($collection as $field=>$value) {
            $set .= " `$field`='" . $value . "',";
        }
        $set = trim($set, ',');
        $sql = "UPDATE " . EVENT_TBL_ALL_TABLE_ALL . " SET $set WHERE ( (meeting_date = '$meeting_date') AND (meeting_time_start = '$meeting_time_start') AND (table_no='$temp_select_avb_table_no') AND ((status != 'Over') OR (ISNULL(status))) )";
        return $this->db->query($sql);
    }
    public function update_data_all2($collection, $meeting_date, $meeting_time_start) {
        $set = '';
        foreach ($collection as $field=>$value) {
            $set .= " `$field`='" . $value . "',";
        }
        $set = trim($set, ',');
        $sql = "UPDATE " . EVENT_TBL_AVBL_TIME_SLOTS . " SET $set WHERE (meeting_date = '$meeting_date') AND (meeting_time_start = '$meeting_time_start') AND (status != 'Over') ";
        return $this->db->query($sql);
    }
    public function get_schedule_data3($user_id) {
        $sql = "SELECT * FROM " . EVENT_TBL_GLBL_MEETING . " WHERE ( (receiver_user_id = '$user_id') AND (status = 'Pending') AND (read_flag != 'True') )";
        return $this->get_list_by_query($sql);
    }
}