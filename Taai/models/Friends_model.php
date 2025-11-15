<?php 
class Friends_model extends Base_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_friends_detail_by_criteria($criteria = array()) {
        return $this->get_detail_by_criteria(EVENT_TBL_FRNDS, $criteria);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_friends_list_paging_by_criteria($criteria = array()) {
        $limit = $where = $whereCondition = '';
        if(isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            $whereCondition .= "owner_id='" . $criteria['user_id'] . "'";
        }
        if(isset($criteria['frnd_id']) && !empty($criteria['frnd_id'])) {
            if(!empty($whereCondition)) {
                $whereCondition .= ' AND ';
            }
            $whereCondition .= "frnd_id !='" . $criteria['frnd_id'] . "'";
        }
        if(isset($criteria['tejfrnd_id']) && !empty($criteria['tejfrnd_id'])) {
            if(!empty($whereCondition)) {
                $whereCondition .= ' AND ';
            }
            $whereCondition .= "frnd_id ='" . $criteria['tejfrnd_id'] . "'";
        }
        
        if(!empty($whereCondition)) {
            $where = " WHERE " . $whereCondition;
        }
        $order_by = " ORDER BY frnd_lname";
        if(isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT ". $criteria['offset'] .", ".$criteria['limit'];
        }
        $sql = "SELECT *
				FROM " . EVENT_TBL_FRNDS . "
				" . $where . $order_by . $limit;
        
        //echo $sql;//exit;
        return $this->get_list_by_query($sql);
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_friends_list_by_criteria($criteria = array()) {
        return $this->get_list_by_criteria(EVENT_TBL_FRNDS, $criteria);
    }
    
    /**
     * This function save the data
     * @param mixed[] $data
     */
    public function save_friends_details($criteria = array()) {
        $criteria['time'] = date('h:i:s a');
        $criteria['date'] = date('Y-m-d');
        //Save user data
        $id = $this->save(EVENT_TBL_FRNDS, $criteria);
        
        return $id;
    }
    
    /**
     * This function return the detail by criteria
     * @param array $criteria
     * @return mixed[] Return the detail
     */
    public function get_friends_list_by_sql($criteria = array()) {
        $whereCondition = 'f.frnd_id=i.user_id';
        if(isset($criteria['user_id']) && !empty($criteria['user_id'])) {
            $whereCondition .= " AND f.owner_id='" . $criteria['user_id'] . "'";
        }
        
        $limit = '';
        $order_by = " ORDER BY f.srno DESC";
        if(isset($criteria['offset']) && isset($criteria['limit'])) {
            $limit = " LIMIT ". $criteria['offset'] .", ".$criteria['limit'];
        }
        
        $sql = "SELECT f.*, i.* 
				FROM " . EVENT_TBL_FRNDS . " f, " . EVENT_TBL_INX_REG_TBL ." i
				WHERE " . $whereCondition . $order_by . $limit;
        
        return $this->get_list_by_query($sql);
    }
}